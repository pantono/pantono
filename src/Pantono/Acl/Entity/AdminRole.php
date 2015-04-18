<?php

namespace Pantono\Acl\Entity;

/**
 * Class AdminRole
 *
 * @package Pantono\Acl\Entity
 * @Entity
 * @Table(name="admin_role")
 * @Repository("Repository\AdminRole")
 */
class AdminRole
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
    protected $name;
    /**
     * @ManyToOne(targetEntity="Pantono\Acl\Entity\AdminRole")
     */
    protected $parent;
}