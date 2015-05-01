<?php namespace Pantono\Metadata;

use Pantono\Core\Entity\Hydrator\EntityHydrator;
use Pantono\Core\Event\Dispatcher;
use Pantono\Metadata\Entity\Repository\MetadataRepository;

class Metadata
{
    private $repository;
    private $dispatcher;
    private $hydrator;

    public function __construct(MetadataRepository $repository, Dispatcher $dispatcher, EntityHydrator $hydrator)
    {
        $this->repository = $repository;
        $this->dispatcher = $dispatcher;
        $this->hydrator = $hydrator;
    }

    public function saveMetadata(array $data)
    {
        $entity = null;
        if (isset($data['id'])) {
            $entity = $this->repository->find($data['id']);
        }
        $hydratedEntity = $this->hydrator->hydrate('Pantono\Metadata\Entity\Metadata', $data, $entity);
        $this->dispatcher->dispatchMetadataEvent(\Pantono\Core\Event\Events\Metadata::PRE_SAVE, $hydratedEntity);
        $this->repository->save($hydratedEntity);
        $this->repository->flush();
        $this->dispatcher->dispatchMetadataEvent(\Pantono\Core\Event\Events\Metadata::POST_SAVE, $hydratedEntity);
    }
}