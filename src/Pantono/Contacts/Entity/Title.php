<?php namespace Pantono\Contacts\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pantono\Database\Entity\EntityAbstract;

/**
 * Class Title
 * @package Pantono\Contacts\Entity
 * @ORM\Entity(repositoryClass="Repository\ContactRepository")
 * @ORM\Table(name="title")
 */
class Title extends EntityAbstract
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
}
