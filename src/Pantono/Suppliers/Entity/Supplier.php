<?php namespace Pantono\Suppliers\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Supplier
 *
 * @package Pantono\Suppliers\Entity
 * @ORM\Entity(repositoryClass="Pantono\Suppliers\Entity\Repository\SuppliersRepository")
 * @ORM\Table(name="supplier")
 */
class Supplier
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
    protected $companyName;
    /**
     * @ORM\Column(type="integer", length=1)
     */
    protected $active;
    /**
     * @ORM\OneToMany(targetEntity="Pantono\Suppliers\Entity\Contact", mappedBy="supplier")
     */
    protected $contacts;

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
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @param mixed $companyName
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * @param mixed $contacts
     */
    public function setContacts($contacts)
    {
        $this->contacts = $contacts;
    }
}
