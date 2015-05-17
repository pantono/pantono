<?php namespace Pantono\Acl\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class AdminUser
 *
 * @package Pantono\Acl\Entity
 * @ORM\Entity(repositoryClass="Pantono\Acl\Entity\Repository\AclRepository")
 * @ORM\Table(name="admin_user")
 */
class AdminUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\OneToOne(targetEntity="Pantono\Contacts\Entity\Contact", cascade={"persist"})
     */
    protected $contact;
    /**
     * @ORM\ManyToMany(targetEntity="Pantono\Acl\Entity\AdminRole")
     */
    protected $role;
    /**
     * @ORM\OneToOne(targetEntity="Pantono\Suppliers\Entity\Supplier")
     */
    protected $supplier;
    /**
     * @ORM\Column(type="string")
     */
    protected $username;
    /**
     * @ORM\Column(type="string")
     */
    protected $password;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $lastLogin;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $superAdmin;

    /**
     * @return mixed
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param mixed $contact
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    }

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
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * @param mixed $lastLogin
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getSupplier()
    {
        return $this->supplier;
    }

    /**
     * @param mixed $supplier
     */
    public function setSupplier($supplier)
    {
        $this->supplier = $supplier;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getSuperAdmin()
    {
        return $this->superAdmin;
    }

    /**
     * @param mixed $superAdmin
     */
    public function setSuperAdmin($superAdmin)
    {
        $this->superAdmin = $superAdmin;
    }
}
