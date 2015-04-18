<?php namespace Pantono\Products\Entity\Repository;

use Pantono\Products\Entity\Product;
use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    /**
     * @param $id
     * @return null|Product
     */
    public function getSingleProduct($id)
    {
        return $this->find($id);
    }
}