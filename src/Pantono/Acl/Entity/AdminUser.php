<?php

namespace Pantono\Acl\Entity;

/**
 * Class AdminUser
 *
 * @package Pantono\Acl\Entity
 * @Entity(repositoryClass="Pantono\Acl\Entity\Repository\AdminUserRepository")
 * @Table(name="admin_user")
 */
class AdminUser
{
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @OneToOne(targetEntity="Pantono\Contacts\Entity\Contact", cascade={"persist"})
     */
    protected $contact;
    /**
     * @OneToOne(targetEntity="Pantono\Acl\Entity\AdminRole")
     */
    protected $role;
    /**
     * @OneToOne(targetEntity="Pantono\Suppliers\Entity\Supplier")
     */
    protected $supplier;
    /**
     * @Column(type="string")
     */
    protected $username;
    /**
     * @Column(type="string")
     */
    protected $password;
    /**
     * @Column(type="datetime", nullable=true)
     */
    protected $lastLogin;

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
}