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

    public function hydrate($entityClass, $data, $existingClass = null)
    {
        $this->currentMetaData = $this->entityManager->getClassMetadata($entityClass);
        $this->setCurrentEntity($entityClass, $existingClass);
        $properties = $this->getPropertiesForEntity($entityClass);
        foreach ($data as $key => $value) {
            if (isset($properties[$key]) && $value !== null) {
                $setterName = ucfirst(Inflector::camelize($key));
                $setter = sprintf('set%s', $setterName);
                $this->mapField($key, $value, $setter);
            }
        }
        return $this->currentEntity;
    }

    private function setCurrentEntity($entityClass, $existingClass)
    {
        $this->currentEntity = $existingClass;
        if ($existingClass == null) {
            $this->currentEntity = new $entityClass;
        }
    }

    public function deHydrate($entity)
    {
        $class = new \ReflectionClass($entity);
        $data = [];
        foreach ($class->getProperties() as $property) {
            $getter = sprintf('get%s', ucfirst(Inflector::camelize($property->getName())));
            $value = $entity->$getter();
            if (is_object($value)) {
                $data[$property->getName()] = $value->getId();
                continue;
            }
            $data[$property->getName()] = $value;
        }
        return $data;
    }

    private function getPropertiesForEntity($entityClass) {
        $reflectionClass = new \ReflectionClass($entityClass);
        $properties = [];
        foreach ($reflectionClass->getProperties() as $property) {
            $properties[$property->getName()] = true;
        }
        return $properties;
    }

    private function mapField($key, $value, $setter)
    {
        if ($this->currentMetaData->hasAssociation($key)) {
            $mapping = $this->currentMetaData->getAssociationMapping($key);
            $targetEntity = $mapping['targetEntity'];
            return $this->getReference($targetEntity, $value);
        }
        if ($key == 'id') {
            $value = intval($value);
        }
        if ($value) {
            $this->currentEntity->{$setter}($value);
        }
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