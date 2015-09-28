<?php namespace Pantono\Assets\Entity\Repository;

use Pantono\Assets\Entity\Type;
use Pantono\Database\Repository\AbstractRepository;

/**
 * Repository methods used for managing Pantono assets
 *
 * Class AssetsRepository
 *
 * @package Pantono\Assets\Entity\Repository
 * @author  Chris Burton <csburton@gmail.com>
 */
class AssetsRepository extends AbstractRepository
{
    /**
     * Gets a doctrine reference to the specific asset type ID
     *
     * @param $id
     *
     * @return Type
     * @throws \Doctrine\ORM\ORMException
     */
    public function getTypeReference($id)
    {
        return $this->_em->getReference('Pantono\Assets\Entity\Type', $id);
    }
}
