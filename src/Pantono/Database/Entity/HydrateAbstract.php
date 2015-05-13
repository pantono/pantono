<?php namespace Pantono\Database\Entity;

use Pantono\Database\Doctrine\ManagerRegistry;
use Pantono\Database\Model\EntityMapping;

abstract class HydrateAbstract
{
    private $managerRegistry;
    protected $ignoreFields = [
        '__initializer__',
        '__cloner__',
        '__isInitialized__',
        'lazyPropertiesDefaults'
    ];
    private $mapping;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    protected function explodeFieldNameParts($name)
    {
        $parts = explode('.', $name);
        $class = array_shift($parts);
        $field = implode('.', $parts);
        return [$class, $field];
    }

    /**
     * @param $string
     * @return mixed
     */
    protected function camelize($string)
    {
        return str_replace(" ", "", ucwords(strtr($string, "_-", "  ")));
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->managerRegistry->getManager('default');
    }

    /**
     * @return EntityMapping
     */
    public function getMapping()
    {
        return $this->mapping;
    }

    /**
     * @param mixed $mapping
     */
    public function setMapping(EntityMapping $mapping)
    {
        $this->mapping = $mapping;
    }
}