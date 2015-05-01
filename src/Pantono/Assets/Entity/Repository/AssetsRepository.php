<?php namespace Pantono\Assets\Entity\Repository;

use Pantono\Database\Repository\AbstractRepository;

class AssetsRepository extends AbstractRepository
{
    public function getTypeReference($id)
    {
        return $this->_em->getReference('Pantono\Assets\Entity\Type', $id);
    }
}