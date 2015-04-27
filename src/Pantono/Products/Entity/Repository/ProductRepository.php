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

    public function getProducts()
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('p')
            ->from('Products\Entity\Product', 'p');
        return $qb->getQuery()->getResult();
    }
}