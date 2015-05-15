<?php namespace Pantono\Database\Repository;

use Doctrine\ORM\EntityRepository;

abstract class AbstractRepository extends EntityRepository
{
    public function save($entity)
    {
        $this->_em->persist($entity);
    }

    public function merge($entity)
    {
        $this->_em->merge($entity);
    }

    public function flush()
    {
        $this->_em->flush();
    }
}
