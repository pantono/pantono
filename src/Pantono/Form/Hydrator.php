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
    private $ignoreFields = [
        '__initializer__',
        '__cloner__',
        '__isInitialized__',
        'lazyPropertiesDefaults'
    ];

    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function flattenEntity($entity, $fieldPrefix = '')
    {
        $class = new \ReflectionClass($entity);
        $data = [];
        foreach ($class->getProperties() as $property) {
            if (in_array($property->getName(), $this->ignoreFields)) {
                continue;
            }
            $field = lcfirst($this->camelize($property->getName()));
            $getter = 'get' . $field;
            $value = $entity->$getter();
            if (is_object($value)) {
                $data = array_merge($data, $this->flattenEntity($value, $field . '_'));
                continue;
            }
            $data[$fieldPrefix . $field] = $value;
        }
        return $data;
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
        $mappings = $this->getMappings();

        $entity = $this->getBaseEntity();
        foreach ($mappings as $field => $mapping) {
            $value = isset($data[$field]) ? $data[$field] : null;
            $this->mapField($entity, $value, $mapping);
        }
        return $entity;
    }

    /**
     * @param $entity
     * @param $value
     * @param $mapping
     * @throws \Exception
     */
    private function mapField($entity, $value, $mapping)
    {
        $mappingParts = explode('.', $mapping);
        $field = array_pop($mappingParts);
        if (sizeof($mappingParts) === 2) {
            $subEntity = $this->getEntityFromId($mappingParts[1]);
            if ($subEntity) {
                $value = $this->mapValueToEntityValue(get_class($subEntity), $field, $value);
            }
            if (!$subEntity) {
                $subEntity = $this->getEntityFromId($mappingParts[0] . '.' . $mappingParts[1]);
            }
            $this->applyValueToEntity($subEntity, $field, $value);
            $this->applyValueToEntity($entity, $mappingParts[1], $subEntity);
            return;
        }
        $this->applyValueToEntity($entity, $field, $value);
    }

    /**
     * @param $entity
     * @param $field
     * @param $value
     * @throws \Exception
     */
    private function applyValueToEntity($entity, $field, $value)
    {
        $value = $this->mapValueToEntityValue(get_class($entity), $field, $value);
        $setter = 'set' . $this->camelize($field);
        if (!method_exists($entity, $setter)) {
            throw new \Exception('Setter ' . get_class($entity) . '::' . $setter . ' does not exist');
        }
        $entity->$setter($value);
    }

    /**
     * @param $class
     * @param $field
     * @param $value
     * @return bool|\Doctrine\Common\Proxy\Proxy|null|object
     * @throws \Doctrine\ORM\Mapping\MappingException
     * @throws \Doctrine\ORM\ORMException
     */
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
        $entity = $this->getEntityFromId($keys[0]);
        if ($entity === false) {
            throw new \Exception('Base entity not found');
        }
        return $entity;
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function getMappedEntities()
    {
        $config = $this->getFormBuilder()->getConfig();
        $mappings = isset($config['entityMapping']) ? $config['entityMapping'] : [];
        foreach ($mappings as $name => $class) {
            $mappings = array_merge($mappings, $this->getAssociationMappings($name, $class));
        }
        $this->checkMappingClasses($mappings);
        return $mappings;
    }

    /**
     * @param $mappings
     * @throws EntityNotExists
     */
    private function checkMappingClasses($mappings)
    {
        foreach ($mappings as $class) {
            if (!class_exists($class)) {
                throw new EntityNotExists('Entity ' . $class . ' does not exist');
            }
        }
    }

    /**
     * @param $id
     * @param $class
     * @return array
     */
    private function getAssociationMappings($id, $class)
    {
        $metaData = $this->getEntityManager()->getClassMetadata($class);
        $mappings = [];
        foreach ($metaData->getAssociationMappings() as $field => $mapping) {
            $mappings[$id . '.' . $field] = $mapping['targetEntity'];
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