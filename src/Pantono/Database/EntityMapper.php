<?php namespace Pantono\Database;

use Pantono\Database\Doctrine\ManagerRegistry;
use Pantono\Database\Exception\MappingNotFound;
use Pantono\Database\Model\EntityMapping;

class EntityMapper
{
    private $mappings;
    private $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * Get mapping by it's name (id)
     * @param $name
     * @return mixed
     * @throws MappingNotFound
     */
    public function getMappingByName($name)
    {
        if (!isset($this->mappings[$name])) {
            throw new MappingNotFound('Mapping '.$name.' does not exist');
        }
        return $this->mappings[$name];
    }

    /**
     * Add new mapping to the mapper locator
     * @param EntityMapping $mapping
     */
    public function addMapping(EntityMapping $mapping)
    {
        $this->mappings[$mapping->getName()] = $mapping;
    }
}