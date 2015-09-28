<?php namespace Pantono\Acl;

use Pantono\Acl\Entity\AdminPrivilege;
use Pantono\Acl\Entity\AdminRole;
use Pantono\Acl\Entity\AdminUser;
use Pantono\Acl\Entity\Repository\AclRepository;
use Pantono\Acl\Exception\Acl\RoleAddError;
use Pantono\Acl\Exception\Acl\RoleNotFound;
use Pantono\Acl\Model\Voter;
use Pantono\Acl\Voter\VoterInterface;
use Pantono\Core\Bootstrap;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Provides methods for ACL related functionality
 *
 * Class Acl
 *
 * @package Pantono\Acl
 * @author  Chris Burton <csburton@gmail.com>
 */
class Acl
{
    /**
     * @var AclRepository
     */
    private $repository;
    /**
     * @var array
     */
    private $voters = [];
    /**
     * @var Session
     */
    private $session;
    /**
     * @var PrivilegeRegistry
     */
    private $privilegeRegistry;
    /**
     * @var Bootstrap
     */
    private $bootstrap;

    const ANONYMOUS_USER_ROLE = 1;

    /**
     * @param AclRepository     $repository
     * @param Session           $session
     * @param PrivilegeRegistry $privilegeRegistry
     * @param Bootstrap         $bootstrap
     */
    public function __construct(
        AclRepository $repository,
        Session $session,
        PrivilegeRegistry $privilegeRegistry,
        Bootstrap $bootstrap
    ) {
        $this->repository = $repository;
        $this->session = $session;
        $this->privilegeRegistry = $privilegeRegistry;
        $this->bootstrap = $bootstrap;
    }

    public function getRolesWithUserCounts()
    {
        return $this->repository->getRolesWithUserCounts();
    }

    /**
     * Loads Privileges into registry
     *
     * @throws Exception\Acl\RoleNotFound
     */
    public function loadPrivileges()
    {
        $roles = $this->repository->getRoles();
        $privileges = $this->repository->getPrivileges();
        foreach ($roles as $role) {
            $parent = null;
            if ($role->getParent()) {
                $parent = $role->getParent()->getName();
            }
            $this->privilegeRegistry->addRole($role->getName(), $parent);
        }
        foreach ($privileges as $privilege) {
            $this->privilegeRegistry->addPrivilege(
                $privilege->getResource(),
                $privilege->getPrivilege(),
                $privilege->getRoleArray()
            );
        }
    }

    /**
     * Add's a voter which can be used to vote on if an action is allowed or not
     *
     * @param Voter $voter
     */
    public function addVoter(Voter $voter)
    {
        $this->voters[$voter->getResource() . '::' . $voter->getAction()] = $voter;
    }


    /**
     * Returns whether or not the specified resource/action is
     *
     * @param string   $resource  Resource to check
     * @param string   $action    Action to check
     * @param array    $arguments array of arguments to pass into check
     * @param null|int $userId    User id to check, will default to currently logged in user if not supplied
     *
     * @return bool
     */
    public function isAllowed($resource, $action, $arguments = [], $userId = null)
    {
        $user = $this->getUserFromId($userId);
        if (!$user) {
            return false;
        }
        if ($user->getSuperAdmin()) {
            return true;
        }
        $isAllowed = $this->isAllowedRegistry($resource, $action, $user);
        $voters = $this->getVotersForAction($resource, $action);
        if (empty($voters)) {
            return $isAllowed;
        }
        return $this->isAllowedVoters($resource, $action, $arguments, $user);
    }

    /**
     * Checks if a role is allowed to access the specific resource/action pair
     *
     * @param string $resource
     * @param string $action
     * @param string $roleName
     *
     * @return bool
     */
    public function isRoleAllowed($resource, $action, $roleName)
    {
        return $this->privilegeRegistry->isRoleAllowed($roleName, $resource, $action);
    }

    /**
     * Gets an array of defined permissions
     *
     * @return array
     */
    public function getDefinedPermissions()
    {
        $modules = $this->bootstrap->getModules();
        $permissions = [];
        foreach ($modules as $module) {
            $permissions = array_merge($permissions, $module->getPermissions());
        }
        ksort($permissions);
        return $permissions;
    }

    /**
     * Update all privileges given the input array
     *
     * @param array $resources Array of resources to insert
     *
     * @return bool
     */
    public function updatePrivileges(array $resources)
    {
        $this->repository->deleteAllPrivileges();
        foreach ($resources as $resource => $actions) {
            foreach ($actions as $privilege => $roles) {
                $permission = new AdminPrivilege();
                $permission->setResource($resource);
                $permission->setAllowed(true);
                $permission->setPrivilege($privilege);
                $permission->setRoles($this->repository->getRoleReferences(array_keys($roles)));
                $this->repository->save($permission);
            }
        }
        $this->repository->flush();
        return true;
    }

    /**
     * Deletes a role from the database
     *
     * @param int $id Role ID to delete
     *
     * @return bool
     *
     * @throws RoleNotFound
     */
    public function deleteRole($id)
    {
        $role = $this->repository->getSingleRole($id);
        if ($id == self::ANONYMOUS_USER_ROLE || !$role) {
            throw new RoleNotFound('Role does not exist');
        }
        $this->repository->delete($role);
        $this->repository->flush();
        return true;
    }

    /**
     * Adds a new role
     *
     * @param string $roleName Name of the role to add
     *
     * @return AdminRole
     * @throws RoleAddError
     */
    public function addRole($roleName)
    {
        if (!$roleName) {
            throw new RoleAddError('Role name is required');
        }

        $exists = $this->repository->findRoleByName($roleName);
        if ($exists !== null) {
            throw new RoleAddError('Role name must be unique');
        }

        $role = new AdminRole();
        $role->setName($roleName);
        $this->repository->save($role);
        $this->repository->flush();
        return $role;
    }

    /**
     * Gets list of roles currently in the database
     *
     * @return array
     */
    public function getRoleList()
    {
        $roles = [];
        $roleList = $this->repository->getRoles();
        foreach ($roleList as $role) {
            $roles[$role->getId()] = $role->getName();
        }
        return $roles;
    }

    /**
     * Checks all voters registered to the provided resource/action
     *
     * @param string    $resource  Resource name to check
     * @param string    $action    Action name to check
     * @param array     $arguments Arguments to pass into check
     * @param AdminUser $user      User to check
     *
     * @return bool
     */
    private function isAllowedVoters($resource, $action, $arguments, AdminUser $user)
    {
        $voters = $this->getVotersForAction($resource, $action);
        if (is_array($voters)) {
            foreach ($voters as $voter) {
                if ($voter->isAllowed($resource, $action, $arguments, $user)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Checks internal ACL database for access to specified resource/action
     *
     * @param string    $resource Resource to check
     * @param string    $action   Action to check
     * @param AdminUser $user     User to check
     *
     * @return bool
     */
    private function isAllowedRegistry($resource, $action, AdminUser $user)
    {
        $roles = $this->getRolesForUser($user);
        foreach ($roles as $role) {
            if ($this->privilegeRegistry->isRoleAllowed($role['name'], $resource, $action)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get roles for specified user
     *
     * @param AdminUser $user User entity
     *
     * @return array|Entity\AdminRole[]
     */
    private function getRolesForUser(AdminUser $user)
    {
        if ($user->getAnonymous()) {
            $anonymousRole = $this->repository->getSingleRole(self::ANONYMOUS_USER_ROLE);
            return [[
                'id' => $anonymousRole->getId(),
                'name' => $anonymousRole->getName(),
                'parent' => $anonymousRole->getParent()
            ]];
        }
        return $this->repository->getRolesForUser($user->getId());
    }


    /**
     * Returns user object for specified ID, if user is null, currently logged in user will be used
     *
     * @param null|int $userId User id to check
     *
     * @return AdminUser|null
     */
    private function getUserFromId($userId = null)
    {
        if ($userId === null) {
            $userId = $this->session->get('admin_user_id');
        }
        if (!$userId) {
            $user = new AdminUser();
            $user->setAnonymous(true);
            $user->setId(-1);
            $role = $this->repository->getSingleRole(self::ANONYMOUS_USER_ROLE);
            $user->setRoles([$role]);
            return $user;
        }
        return $this->repository->getUserInfo($userId);
    }

    /**
     * Gets voters for specified action
     *
     * @param string $resource Resource Name
     * @param string $action   Action Name
     *
     * @return VoterInterface[]
     */
    private function getVotersForAction($resource, $action)
    {
        return isset($this->voters[$resource . '::' . $action]) ? $this->voters[$resource . '::' . $action] : [];
    }
}
