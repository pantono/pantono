<?php namespace Pantono\Acl\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class AdminPrivilege
 *
 * @package Pantono\Acl\Entity
 * @ORM\Entity
 * @ORM\table(name="admin_privilege")
 */
class AdminPrivilege
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
    protected $name;
    /**
     * @ORM\OneToOne(targetEntity="Pantono\Acl\Entity\AdminRole")
     */
    protected $role;
    /**
     * @ORM\Column(type="integer")
     */
    protected $allowed;
}
