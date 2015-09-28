<?php namespace Pantono\Acl;

/**
 * Provides functionality around managing the privilege registry
 *
 * Class PrivilegeRegistry
 *
 * @package Pantono\Acl
 * @author  Chris Burton <csburton@gmail.com>
 */
class PrivilegeRegistry
{
    /**
     * @var array
     */
    private $resources = [];
    /**
     * @var array
     */
    private $privileges = [];
    /**
     * @var array
     */
    private $roles = [];

    /**
     * Adds a new resource to the registry
     *
     * @param string $resource
     */
    public function addResource($resource)
    {
        $this->resources[] = $resource;
    }

    /**
     * Adds a new role to the database
     *
     * @param string $role   Role name
     * @param string $parent Parent role name
     */
    public function addRole($role, $parent)
    {
        $this->roles[$role] = [
            'role' => $role,
            'parent' => $parent
        ];
    }

    /**
     * Add new privilege to the registry
     *
     * @param string $resource  Resource Name
     * @param string $privilege Privilege Name
     * @param array  $roles     Array of role names
     */
    public function addPrivilege($resource, $privilege, array $roles)
    {
        if (!in_array($resource, $this->resources)) {
            $this->addResource($resource);
        }
        $this->privileges[$resource][$privilege] = [
            'roles' => $roles
        ];
    }

    /**
     * Checks if a role is allowed to access the specified resource/privilege pair
     *
     * @param string $role      Role name
     * @param string $resource  Resource Name
     * @param string $privilege Privilege Name
     *
     * @return bool
     */
    public function isRoleAllowed($role, $resource, $privilege)
    {
        $privilege = $this->privileges[$resource][$privilege];
        $parents = $this->getRoleParents($role);
        if (in_array($role, $privilege['roles'])) {
            return true;
        }
        foreach ($parents as $parent) {
            if (in_array($parent, $privilege['roles'])) {
                return true;
            }
        }
        return false;
    }

    /**
     * Appends role parents to the roleArray argument
     *
     * @param string $role      Role Name
     * @param array  $roleArray Role array to append to
     *
     * @return array
     */
    private function getRoleParents($role, $roleArray = [])
    {
        if (!isset($this->roles[$role])) {
            return [];
        }
        $parent = $this->roles[$role]['parent'];
        $roleArray[] = $parent;
        return array_merge($roleArray, $parent);
    }

    /**
     * Gets current resources list
     *
     * @return array
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * Gets current privileges list
     *
     * @return array
     */
    public function getPrivileges()
    {
        return $this->privileges;
    }

    /**
     * Gets current role list
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }
}
