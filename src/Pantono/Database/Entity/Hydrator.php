<?php namespace Pantono\Database\Entity;

use Pantono\Database\Model\EntityMapping;
use Pantono\Database\Model\FieldMapping;

class Hydrator extends HydrateAbstract
{
    private $entities;
    private $data;

    public function hydrateEntity(EntityMapping $mapping, $data)
    {
        $this->data = $data;
        $this->setMapping($mapping);
        $entity = $this->getBaseEntity();
        foreach ($mapping->getFields() as $field) {
            $this->mapFieldToEntity($entity, $field, $data);
        }
        return $entity;
    }

    private function mapFieldToEntity($entity, FieldMapping $field, $data)
    {
        $fieldData = isset($data[$field->getSourceField()]) ? $data[$field->getSourceField()] : null;
        if ($fieldData === null) {
            return;
        }
        list($baseEntityClassName, $fieldName) = $this->explodeFieldNameParts($field->getTargetField());
        if (strstr($fieldName, '.')) {
            list($relationFieldName, $fieldName) = $this->explodeFieldNameParts($fieldName);
            $class = $this->getEntityFromId($baseEntityClassName . '.' . $relationFieldName);
            $entitySetter = 'set' . $this->camelize($relationFieldName);
            $fieldSetter = 'set' . $this->camelize($fieldName);
            $class->$fieldSetter($fieldData);
            $entity->$entitySetter($class);
            return;
        }
        $setter = 'set' . $this->camelize($fieldName);
        $entity->$setter($fieldData);
    }

    private function getBaseEntity()
    {
        $entities = $this->getMapping()->getEntities();
        $keys = array_keys($entities);
        $entity = $this->getEntityFromId($keys[0]);
        if ($entity === false) {
            throw new \Exception('Base entity not found');
        }
        return $entity;
    }

    /**
     * @param $id
     * @return object|bool
     * @throws \Exception
     */
    private function getEntityFromId($id)
    {
        if (!isset($this->entities[$id])) {
            $entities = $this->getMapping()->getEntities();
            $this->addAssociationEntities($entities);
            if (!isset($entities[$id])) {
                return false;
            }
            $this->entities[$id] = $this->generateEntityClass($id, $entities[$id]);
        }
        return $this->entities[$id];
    }

    private function addAssociationEntities(&$entities)
    {
        foreach ($entities as $entityName => $entity) {
            $metadata = $this->getEntityManager()->getClassMetadata($entity);
            foreach ($metadata->associationMappings as $field => $data) {
                $entities[$entityName . '.' . $field] = $data['targetEntity'];
            }
        }
    }

    private function generateEntityClass($id, $entityClass)
    {
        $idField = $this->getIdFieldForEntity($entityClass);
        $dataFieldName = $this->getDataFieldNameFromMapping($id.'.'.$idField);
        if (isset($this->data[$dataFieldName])) {
            return $this->getEntityManager()->getRepository($entityClass)->find($this->data[$dataFieldName]);
        }
        return new $entityClass;
    }

    private function getDataFieldNameFromMapping($fieldName)
    {
        foreach ($this->getMapping()->getFIelds() as $field) {
            if ($field->getTargetField() == $fieldName) {
                return $field->getSourceField();
            }
        }
        return $fieldName;
    }

    private function getIdFieldForEntity($entityClass)
    {
        $metaData = $this->getEntityManager()->getClassMetadata($entityClass);
        if (sizeof($metaData->identifier) == 1) {
            return $metaData->identifier[0];
        }
        return null;
    }
}