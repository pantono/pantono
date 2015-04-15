<?php

namespace Pantona\Acl\Entity;

/**
 * Class AdminRole
 *
 * @package Pantona\Acl\Entity
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
     * @ManyToOne(targetEntity="Pantona\Acl\Entity\AdminRole")
     */
    protected $parent;
}