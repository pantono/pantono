<?php namespace Pantona\Products\Entity\Repository;

use Pantona\Products\Entity\Product;
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