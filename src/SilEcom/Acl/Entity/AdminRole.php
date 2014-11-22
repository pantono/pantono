<?php

namespace SilEcom\Acl\Entity;

/**
 * Class AdminRole
 *
 * @package SilEcom\Acl\Entity
 * @Entity
 * @Table(name="admin_role")
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
     * @ManyToOne(targetEntity="SilEcom\Acl\Entity\AdminRole")
     */
    protected $parent;
}