<?php

namespace Pantono\Assets\Entity;

/**
 * Class Asset
 *
 * @package Pantono\Assets\Entity
 * @Entity(repositoryClass="Pantono\Assets\Entity\Repository\AssetsRepository")
 * @Table(name="asset")
 */
class Asset
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @ManyToOne(targetEntity="Pantono\Assets\Entity\Type")
     */
    protected $type;
    /**
     * @Column(type="string")
     */
    protected $filename;
    /**
     * @Column(type="integer")
     */
    protected $filesize;
    /**
     * @Column(type="string")
     */
    protected $mimeType;
    /**
     * @Column(type="string")
     */
    protected $publicUrl;

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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param mixed $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return mixed
     */
    public function getFilesize()
    {
        return $this->filesize;
    }

    /**
     * @param mixed $filesize
     */
    public function setFilesize($filesize)
    {
        $this->filesize = $filesize;
    }

    /**
     * @return mixed
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @param mixed $mimeType
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    }

    /**
     * @return mixed
     */
    public function getPublicUrl()
    {
        return $this->publicUrl;
    }

    /**
     * @param mixed $publicUrl
     */
    public function setPublicUrl($publicUrl)
    {
        $this->publicUrl = $publicUrl;
    }
}
