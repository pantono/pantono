<?php namespace Pantono\Acl\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pantono\Database\Entity\EntityAbstract;

/**
 * Class AdminPrivilege
 *
 * @package Pantono\Acl\Entity
 * @ORM\Entity(repositoryClass="Pantono\Acl\Entity\Repository\AclRepository")
 * @ORM\table(name="admin_privilege")
 */
class AdminPrivilege extends EntityAbstract
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\Column(type="string")
     */
    protected $resource;
    /**
     * @ORM\Column(type="string")
     */
    protected $privilege;
    /**
     * @ORM\ManyToMany(targetEntity="Pantono\Acl\Entity\AdminRole")
     */
    protected $roles;
    /**
     * @ORM\Column(type="integer")
     */
    protected $allowed;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param mixed $resource
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    /**
     * @return mixed
     */
    public function getPrivilege()
    {
        return $this->privilege;
    }

    /**
     * @param mixed $privilege
     */
    public function setPrivilege($privilege)
    {
        $this->privilege = $privilege;
    }

    /**
     * @return AdminRole[]
     */
    public function getRoles()
    {
        return $this->roles;
    }

    public function getRoleArray()
    {
        $roles = [];
        foreach ($this->getRoles() as $role)
        {
            $roles[] = $role->getName();
        }
        return $roles;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return mixed
     */
    public function getAllowed()
    {
        return $this->allowed;
    }

    /**
     * @param mixed $allowed
     */
    public function setAllowed($allowed)
    {
        $this->allowed = $allowed;
    }
}
