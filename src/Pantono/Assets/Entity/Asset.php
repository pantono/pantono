<?php namespace Pantono\Assets\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Class Asset
 *
 * @package Pantono\Assets\Entity
 * @ORM\Entity(repositoryClass="Pantono\Assets\Entity\Repository\AssetsRepository")
 * @ORM\Table(name="asset")
 */
class Asset
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="Pantono\Assets\Entity\Type")
     */
    protected $type;
    /**
     * @ORM\Column(type="string")
     */
    protected $filename;
    /**
     * @ORM\Column(type="integer")
     */
    protected $filesize;
    /**
     * @ORM\Column(type="string")
     */
    protected $mimeType;
    /**
     * @ORM\Column(type="string")
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
