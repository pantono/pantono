<?php namespace Pantono\Metadata;

use Pantono\Metadata\Entity\Metadata as MetadataEntity;
use Pantono\Core\Event\Dispatcher;
use Pantono\Metadata\Entity\Repository\MetadataRepository;

class Metadata
{
    private $repository;
    private $dispatcher;

    public function __construct(MetadataRepository $repository, Dispatcher $dispatcher)
    {
        $this->repository = $repository;
        $this->dispatcher = $dispatcher;
    }

    public function saveMetadata(MetadataEntity $entity)
    {
        $this->dispatcher->dispatchMetadataEvent(\Pantono\Core\Event\Events\Metadata::PRE_SAVE, $entity);
        $this->repository->save($entity);
        $this->repository->flush();
        $this->dispatcher->dispatchMetadataEvent(\Pantono\Core\Event\Events\Metadata::POST_SAVE, $entity);
        return $entity;
    }
}