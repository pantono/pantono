<?php namespace Pantono\Acl;

use Pantono\Acl\Entity\AdminUser;
use Pantono\Acl\Entity\Repository\AclRepository;
use Pantono\Acl\Model\Voter;
use Pantono\Acl\Voter\VoterInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class Acl
{
    private $repository;
    private $voters;
    private $session;
    private $privilegeRegistry;

    public function __construct(AclRepository $repository, Session $session, PrivilegeRegistry $privilegeRegistry)
    {
        $this->repository = $repository;
        $this->session = $session;
        $this->privilegeRegistry = $privilegeRegistry;
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
            $this->privilegeRegistry->addPrivilege($privilege->getResource(), $privilege->getPrivilege(), $privilege->getRoleArray());
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
     * @param $resource
     * @param $action
     * @param array $arguments
     * @param null $userId
     * @return bool
     */
    public function isAllowed($resource, $action, $arguments = [], $userId = null)
    {
        $user = $this->getUserFromId($userId);
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
     * @param null $userId
     * @return AdminUser|null
     */
    private function getUserFromId($userId = null)
    {
        if (!$userId) {
            $userId = $this->session->get('admin_user_id');
        }
        return $this->repository->getUserInfo($userId);
    }

    /**
     * Checks all voters registered to the provided resource/action
     *
     * @param $resource
     * @param $action
     * @param $arguments
     * @param AdminUser $user
     * @return bool
     */
    private function isAllowedVoters($resource, $action, $arguments, AdminUser $user)
    {
        foreach ($this->getVotersForAction($resource, $action) as $voter) {
            if ($voter->isAllowed($resource, $action, $arguments)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Checks internal ACL database for access to specified resource/action
     *
     * @param $resource
     * @param $action
     * @param AdminUser $user
     * @return bool
     */
    private function isAllowedRegistry($resource, $action, AdminUser $user)
    {
        $roles = $this->repository->getRolesForUser($user->getId());
        foreach ($roles as $role) {
            if ($this->privilegeRegistry->isRoleAllowed($role['name'], $resource, $action)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $resource
     * @param $action
     * @return VoterInterface[]
     */
    private function getVotersForAction($resource, $action)
    {
        return isset($this->voters[$resource . '::' . $action]) ? $this->voters[$resource . '::' . $action] : [];
    }
}