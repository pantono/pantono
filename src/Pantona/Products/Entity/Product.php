<?php
namespace Pantona\Products\Entity;

/**
 * Class Product
 *
 * @package Pantona\Products\Entity
 * @Entity(repositoryClass="Pantona\Products\Entity\Repository\ProductRepository")
 * @Table(name="products")
 */
class Product
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @OneToOne(targetEntity="Pantona\Products\Entity\Draft")
     */
    protected $draft;
    /**
     * @OneToOne(targetEntity="Pantona\Products\Entity\Status")
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