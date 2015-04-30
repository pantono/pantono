<?php namespace Pantono\Core\Entity\Hydrator;

use Doctrine\ORM\EntityManager;
use ReflectionObject;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Util\Inflector;

class EntityHydrator
{
    private $entityManager;
    private $currentEntity;
    /**
     * @var \Doctrine\ORM\Mapping\ClassMetadata
     */
    private $currentMetaData;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function hydrate($entityClass, $data)
    {
        $this->currentMetaData = $this->entityManager->getClassMetadata($entityClass);
        $this->currentEntity = new $entityClass;
        $reflectionClass = new \ReflectionClass($entityClass);
        foreach ($reflectionClass->getProperties() as $property) {
            $properties[$property->getName()] = true;
        }
        foreach ($data as $key => $value) {
            if (isset($properties[$key]) && $value !== null) {
                $setter = sprintf('set%s', ucfirst(Inflector::camelize($key)));
                $value = $this->mapField($key, $value);
                if ($value) {
                    $this->currentEntity->{$setter}($value);
                }
            }
        }
        return $this->currentEntity;
    }

    private function mapField($key, $value)
    {
        if ($this->currentMetaData->hasAssociation($key)) {
            $mapping = $this->currentMetaData->getAssociationMapping($key);
            $targetEntity = $mapping['targetEntity'];
            return $this->getReference($targetEntity, $value);
        }
        return $value;
    }

    private function getReference($entityClass, $value)
    {
        if (is_array($value)) {
            $values = [];
            foreach ($value as $manyValue)
            {
                $values[] = $this->getReference($entityClass, $manyValue);
            }
            return $values;
        }

        return $this->entityManager->getReference($entityClass, $value);
    }
}