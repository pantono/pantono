<?php namespace Pantono\Products\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Product
 *
 * @package Pantono\Products\Entity
 * @ORM\Entity(repositoryClass="Pantono\Products\Entity\Repository\ProductRepository")
 * @ORM\Table(name="products")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\OneToOne(targetEntity="Pantono\Products\Entity\Draft")
     */
    protected $draft;
    /**
     * @ORM\OneToOne(targetEntity="Pantono\Products\Entity\Status")
     */
    protected $status;

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
     * @return Draft
     */
    public function getDraft()
    {
        return $this->draft;
    }

    /**
     * @param mixed Draft
     */
    public function setDraft($draft)
    {
        $this->draft = $draft;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}
