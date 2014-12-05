<?php

namespace Csburton\SilEcom\Core\Container;

use Doctrine\ORM\EntityManager;

class Application extends \Silex\Application
{
    /**
     * @param $name
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository($module, $entity)
    {
        $entity= 'Csburton\\SilEcom\\'.$module.'\Entity\\'.$entity;
        return $this->getEntityManager()->getRepository($entity);
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this['orm.em'];
    }
}