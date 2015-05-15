<?php namespace Pantono\Acl\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class AdminRole
 *
 * @package Pantono\Acl\Entity
 * @ORM\Entity(repositoryClass="Repository\AdminRole")
 * @ORM\Table(name="admin_role")
 */
class AdminRole
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
    protected $name;
    /**
     * @ORM\ManyToOne(targetEntity="Pantono\Acl\Entity\AdminRole")
     */
    protected $parent;
}
