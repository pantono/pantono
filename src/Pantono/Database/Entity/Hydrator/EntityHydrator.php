<?php namespace Pantono\Database\Entity\Hydrator;

use Doctrine\ORM\EntityManager;
use Pantono\Database\Doctrine\ManagerRegistry;
use Doctrine\Common\Util\Inflector;

class EntityHydrator
{
    private $entityManager;
    private $managerRegistry;
    /**
     * @var \Doctrine\ORM\Mapping\ClassMetadata
     */
    private $currentMetaData;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function hydrate($entityClass, $data, $existingClass = null)
    {
        $this->currentMetaData = $this->getEntityManager()->getClassMetadata($entityClass);
        $entity = $this->setCurrentEntity($entityClass, $existingClass);
        $properties = $this->getPropertiesForEntity($entityClass);
        foreach ($data as $key => $value) {
            if (isset($properties[$key]) && $value !== null) {
                $setterName = ucfirst(Inflector::camelize($key));
                $setter = sprintf('set%s', $setterName);
                $this->mapField($key, $value, $entity, $setter);
            }
        }
        return $entity;
    }

    private function setCurrentEntity($entityClass, $existingClass)
    {
        $entity = $existingClass;
        if ($existingClass === null) {
            $entity = new $entityClass;
        }
        return $entity;
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

    private function mapField($key, $value, $entity, $setter)
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
            $entity->{$setter}($value);
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

        return $this->getEntityManager()->getReference($entityClass, $value);
    }

    private function getEntityManager()
    {
        return $this->managerRegistry->getManager('default');
    }
}