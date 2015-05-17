<?php namespace Pantono\Acl;

use Pantono\Acl\Exception\Acl\RoleNotFound;

class PrivilegeRegistry
{
    private $resources;
    private $privileges;
    private $roles;

    public function addResource($resource)
    {
        $this->resources[] = $resource;
    }

    public function addRole($role, $parent)
    {
        $this->roles[$role] = [
            'role' => $role,
            'parent' => $parent
        ];
    }

    public function addPrivilege($resource, $privilege, $roles)
    {
        if (!in_array($resource, $this->resources)) {
            throw new RoleNotFound('Resource ' . $resource . ' has not been registered. Add before registering privilege ');
        }
        $this->privileges[$resource][$privilege] = [
            'roles' => $roles
        ];
    }

    public function isRoleAllowed($role, $resource, $privilege)
    {
        $privilege = $this->privileges[$resource][$privilege];
        $parents = $this->getRoleParents($role);
        if (in_array($role, $privilege)) {
            return true;
        }
        foreach ($parents as $parent)
        {
            if (in_array($parent, $privilege['roles'])) {
                return true;
            }
        }
        return false;
    }

    private function getRoleParents($role, $roleArray = [])
    {
        if (!isset($this->roles[$role])) {
            return [];
        }
        $parent = $this->roles[$role]['parent'];
        $roleArray[] = $parent;
        return array_merge($roleArray, $parent);
    }
}