<?php namespace Pantono\Categories\Entity;

/**
 * Class CategoryStatus
 * @package Pantono\Categories\Entity
 * @Entity(repositoryClass="Pantono\Categories\Entity\Repository\CategoryRepository")
 * @Table(name="category_status")
 */
class CategoryStatus
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    /**
     * @Column(type="text")
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