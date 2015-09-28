<?php namespace Pantono\Products\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Brand
 *
 * @package Pantono\Products\Entity
 * @ORM\Entity(repositoryClass="Pantono\Products\Entity\Repository\ProductRepository")
 * @ORM\Table(name="product_brand")
 */
class Brand extends EntityAbstrac
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
     * @ORM\OneToOne(targetEntity="Pantono\Assets\Entity\Asset")
     */
    protected $logo;

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
     * @param int $id ID
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
     * Sets name
     *
     * @param string $name Name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Gets logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Sets logo
     *
     * @param string $logo Logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }
}
