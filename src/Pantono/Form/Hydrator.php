<?php namespace Pantono\Form;

use Pantono\Database\Doctrine\ManagerRegistry;
use Pantono\Form\Exception\EntityNotExists;
use Symfony\Component\Form\FormBuilder;

class Hydrator
{
    private $formWrapper;
    private $formBuilder;
    private $managerRegistry;
    private $entities;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @param FormBuilder $formWrapper
     * @param array $data
     * @return null|object
     * @throws EntityNotExists
     * @throws \Exception
     */
    public function getHydratedEntity(FormBuilder $formWrapper, array $data)
    {
        $this->formWrapper = $formWrapper;
        $this->formBuilder = $formWrapper->getType()->getInnerType();
        $entities = $this->getMappedEntities();
        if (empty($entities)) {
            return null;
        }
        foreach ($entities as $name => $class) {
            if (!class_exists($class)) {
                throw new EntityNotExists('Entity ' . $class . ' does not exist');
            }
        }
        $mappings = $this->getMappings();

        $entity = $this->getBaseEntity();
        foreach ($mappings as $field => $mapping) {
            $value = isset($data[$field]) ? $data[$field] : null;
            $this->mapField($entity, $value, $mapping);
        }
        return $this->getEntityManager()->merge($entity);
    }

    /**
     * @param $entity
     * @param $value
     * @param $mapping
     * @return Object
     * @throws \Exception
     */
    private function mapField($entity, $value, $mapping)
    {
        $mappingParts = explode('.', $mapping);
        $field = array_pop($mappingParts);
        $setter = 'set' . $this->camelize($field);
        if (sizeof($mappingParts) === 2) {
            $subEntity = $this->getEntityFromId($mappingParts[1]);
            if ($subEntity) {
                $value = $this->mapValueToEntityValue(get_class($subEntity), $field, $value);
            }
            if (!$subEntity) {
                $subEntity = $this->getEntityFromId($mappingParts[0].'.'.$mappingParts[1]);
                $value = $this->mapValueToEntityValue(get_class($subEntity), $field, $value);
            }
            $subEntity->$setter($value);
            $subEntitySetter = 'set' . $this->camelize($mappingParts[1]);
            $entity->$subEntitySetter($subEntity);
            return $entity;
        }
        if (sizeof($mappingParts) > 1) {
            throw new \Exception("Can't currently map higher than one level in entity hydrator, sorry!");
        }
        if (!method_exists($entity, $setter)) {
            throw new \Exception('Setter '.get_class($entity).'::'.$setter.' does not exist');
        }
        $value = $this->mapValueToEntityValue(get_class($entity), $field, $value);
        $entity->$setter($value);
    }

    private function mapValueToEntityValue($class, $field, $value)
    {
        $metaData = $this->getEntityManager()->getClassMetadata($class);
        $type = $metaData->getTypeOfField($field);
        if (!$type) {
            $mapping = $metaData->getAssociationMapping($field);
            if (is_int($value)) {
                return $this->getEntityManager()->getReference($mapping['targetEntity'], $value);
            }
        }

        return $value;
    }

    /**
     * @param $id
     * @return object|bool
     * @throws \Exception
     */
    private function getEntityFromId($id)
    {
        if (!isset($this->entities[$id])) {
            $entities = $this->getMappedEntities();
            if (!isset($entities[$id])) {
                return false;
            }
            if (!class_exists($entities[$id])) {
                throw new \Exception('Class ' . $id . ' does not exist');
            }
            $this->entities[$id] = new $entities[$id];
        }
        return $this->entities[$id];
    }

    /**
     * @return object
     * @throws \Exception
     */
    private function getBaseEntity()
    {
        $entities = $this->getMappedEntities();
        $keys = array_keys($entities);
        return $this->getEntityFromId($keys[0]);
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function getMappedEntities()
    {
        $config = $this->getFormBuilder()->getConfig();
        $mappings  = isset($config['entityMapping']) ? $config['entityMapping'] : [];
        foreach ($mappings as $name => $class) {
            $mappings = array_merge($mappings, $this->getAssociationMappings($name, $class));
        }
        return $mappings;
    }

    /**
     * @param $id
     * @param $class
     * @return array
     */
    private function getAssociationMappings($id, $class) {
        $metaData = $this->getEntityManager()->getClassMetadata($class);
        $mappings = [];
        foreach ($metaData->getAssociationMappings() as $field => $mapping) {
            $mappings[$id.'.'.$field] = $mapping['targetEntity'];
        }
        return $mappings;
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function getMappings()
    {
        $mapping = [];
        foreach ($this->getFormBuilder()->getFields() as $name => $field) {
            if (isset($field['mapping'])) {
                $mapping[$name] = $field['mapping'];
            }
        }
        return $mapping;
    }

    /**
     * @return Builder
     * @throws \Exception
     */
    public function getFormBuilder()
    {
        if ($this->formBuilder === null) {
            throw new \Exception('Invalid form passed');
        }
        return $this->formBuilder;
    }

    /**
     * @param Builder $formBuilder
     */
    public function setFormBuilder($formBuilder)
    {
        $this->formBuilder = $formBuilder;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    private function getEntityManager()
    {
        return $this->managerRegistry->getManager('default');
    }

    /**
     * @param $string
     * @return mixed
     */
    private function camelize($string)
    {
        return str_replace(" ", "", ucwords(strtr($string, "_-", "  ")));
    }
}