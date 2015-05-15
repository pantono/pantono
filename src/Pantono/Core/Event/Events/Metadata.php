<?php namespace Pantono\Core\Event\Events;


class Metadata extends General
{
    private $metadata;
    const PRE_SAVE = 'pantono.metadata.pre-save';
    CONST POST_SAVE = 'pantono.metadata.post-save';

    /**
     * @return \Pantono\Metadata\Entity\Metadata
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param \Pantono\Metadata\Entity\Metadata $metadata
     */
    public function setMetadata(\Pantono\Metadata\Entity\Metadata $metadata)
    {
        $this->metadata = $metadata;
    }
}