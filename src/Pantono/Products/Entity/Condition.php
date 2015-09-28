<?php namespace Pantono\Products\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pantono\Database\Entity\EntityAbstract;

/**
 * Class Condition
 *
 * @package Pantono\Products\Entity
 * @ORM\Entity(repositoryClass="Pantono\Products\Entity\Repository\ProductRepository")
 * @ORM\Table(name="product_condition")
 */
class Condition extends EntityAbstract
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
     * Gets ID
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets ID
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Gets Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets Name
     *
     * @param string $name Name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
