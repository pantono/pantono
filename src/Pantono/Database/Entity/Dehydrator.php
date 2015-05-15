<?php namespace Pantono\Database\Entity;

use Pantono\Database\Exception\InvalidMappingEntity;
use Pantono\Database\Model\EntityMapping;

class Dehydrator extends HydrateAbstract
{
    public function dehydrateEntity(EntityMapping $mapping, $entity)
    {
        if (!is_object($entity)) {
            throw new InvalidMappingEntity('Entity that is being de-hydrated must be an object');
        }
        $this->setMapping($mapping);
        $data = $this->mapFields($mapping->getFields(), $entity);
        return $data;
    }

    private function mapFields($fields, $entity)
    {
        $data = [];
        foreach ($fields as $field) {
            $value = $this->getFieldFromFullName($field->getTargetField(), $entity);
            if (is_object($value)) {
                $data[$field->getSourceField()] = $value->getId();
                continue;
            }
            $data[$field->getSourceField()] = $this->getFieldFromFullName($field->getTargetField(), $entity);
        }
        return $data;
    }

    private function getFieldFromFullName($name, $entity)
    {
        $fields = explode('.', $name);
        array_shift($fields);
        $value = clone($entity);
        foreach ($fields as $field) {
            $getter = 'get' . $this->camelize($field);
            if ($value->$getter() === null) {
                return null;
            }
            $value = $value->$getter();
        }
        return $value;
    }
}
