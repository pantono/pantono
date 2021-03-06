<?php namespace Pantono\Categories\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pantono\Database\Entity\EntityAbstract;

/**
 * Class Category
 *
 * @package Pantono\Contacts\Entity
 * @ORM\Entity(repositoryClass="Pantono\Categories\Entity\Repository\CategoryRepository")
 * @ORM\Table(name="category")
 */
class Category extends EntityAbstract
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="Category")
     */
    protected $parent;
    /**
     * @ORM\ManyToOne(targetEntity="CategoryStatus")
     */
    protected $status;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;
    /**
     * @ORM\Column(type="string")
     */
    protected $title;
    /**
     * @ORM\OneToOne(targetEntity="Pantono\Assets\Entity\Asset")
     */
    protected $image;
    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    protected $urlKey;
    /**
     * @ORM\OneToOne(targetEntity="Pantono\Metadata\Entity\Metadata")
     */
    protected $metadata;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $active;

    public function __construct()
    {
        $this->active = false;
    }

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

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getBreadcrumb()
    {
        $items = [$this->getTitle()];
        $parent = $this->getParent();
        while ($parent) {
            $items[] = $parent->getTitle();
            $parent = $parent->getParent();
        }
        return implode(' -> ', $items);
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getUrlKey()
    {
        return $this->urlKey;
    }

    /**
     * @param mixed $urlKey
     */
    public function setUrlKey($urlKey)
    {
        $this->urlKey = $urlKey;
    }

    /**
     * @return mixed
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param mixed $metadata
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
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
}
