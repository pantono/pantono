<?php namespace Pantono\Database\Doctrine;

use Doctrine\ORM\EntityManager;
use Pantono\Core\Container\Application;

class ManagerRegistry
{
    private $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * @param string $name
     * @return EntityManager
     */
    public function getManager($name = 'default')
    {
        return $this->application['orm.ems'][$name];
    }
}