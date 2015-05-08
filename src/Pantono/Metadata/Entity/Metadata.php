<?php

namespace Pantono\Metadata\Entity;

/**
 * Class Metadata
 *
 * @package Pantono\Metadata\Entity
 * @Entity(repositoryClass="Pantono\Metadata\Entity\Repository\MetadataRepository")
 * @Table(name="metadata")
 */
class Metadata
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @Column(type="string", nullable=true)
     */
    protected $pageTitle;
    /**
     * @Column(type="string", nullable=true)
     */
    protected $metaDescription;
    /**
     * @Column(type="string", nullable=true)
     */
    protected $metaKeywords;
    /**
     * @Column(type="string", nullable=true)
     */
    protected $metaRobots;
    /**
     * @Column(type="string", nullable=true)
     */
    protected $metaCanonical;
    /**
     * @Column(type="string", nullable=true)
     */
    protected $navigationTitle;

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
    public function getPageTitle()
    {
        return $this->pageTitle;
    }

    /**
     * @param mixed $pageTitle
     */
    public function setPageTitle($pageTitle)
    {
        $this->pageTitle = $pageTitle;
    }

    /**
     * @return mixed
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * @param mixed $metaDescription
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;
    }

    /**
     * @return mixed
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * @param mixed $metaKeywords
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;
    }

    /**
     * @return mixed
     */
    public function getMetaRobots()
    {
        return $this->metaRobots;
    }

    /**
     * @param mixed $metaRobots
     */
    public function setMetaRobots($metaRobots)
    {
        $this->metaRobots = $metaRobots;
    }

    /**
     * @return mixed
     */
    public function getMetaCanonical()
    {
        return $this->metaCanonical;
    }

    /**
     * @param mixed $metaCanonical
     */
    public function setMetaCanonical($metaCanonical)
    {
        $this->metaCanonical = $metaCanonical;
    }

    /**
     * @return mixed
     */
    public function getNavigationTitle()
    {
        return $this->navigationTitle;
    }

    /**
     * @param mixed $navigationTitle
     */
    public function setNavigationTitle($navigationTitle)
    {
        $this->navigationTitle = $navigationTitle;
    }
}
