<?php

namespace SilEcom\Acl\Entity;

/**
 * Class AdminUser
 *
 * @package SilEcom\Acl\Entity
 * @Entity
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
     * @OneToOne(targetEntity="SilEcom\Contacts\Entity\Contact")
     */
    protected $contact;
    /**
     * @OneToOne(targetEntity="SilEcom\Acl\Entity\AdminRole")
     */
    protected $role;
    /**
     * @OneToOne(targetEntity="SilEcom\Suppliers\Entity\Supplier")
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
     * @Column(type="string")
     */
    protected $salt;
    /**
     * @Column(type="datetime")
     */
    protected $last_login;
}