<?php namespace Pantono\Acl\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class AdminRole
 *
 * @package Pantono\Acl\Entity
 * @ORM\Entity(repositoryClass="Pantono\Acl\Entity\Repository\AclRepository")
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return AdminRole
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }
}
