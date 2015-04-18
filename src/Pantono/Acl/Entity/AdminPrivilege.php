<?php

namespace Pantono\Acl\Entity;

/**
 * Class AdminPrivilege
 *
 * @package Pantono\Acl\Entity
 * @Entity
 * @table(name="admin_privilege")
 */
class AdminPrivilege
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @Column(type="string")
     */
    protected $resource;
    /**
     * @Column(type="string")
     */
    protected $name;
    /**
     * @OneToOne(targetEntity="Pantono\Acl\Entity\AdminRole")
     */
    protected $role;
    /**
     * @Column(type="integer")
     */
    protected $allowed;
}