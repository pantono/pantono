<?php namespace Pantono\Products\Entity\Repository;

use Pantono\Products\Entity\Product;
use Doctrine\ORM\EntityRepository;
use Pantono\Products\Filter\ProductListingFilter;

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

    public function getProducts(ProductListingFilter $filter)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('p')
            ->from('Products\Entity\Product', 'p');
        if ($filter->getName()) {
            $qb->where('p.name like :name')
                ->setParameter('name', '%' . $filter->getName() . '%');
        }
        return $qb->getQuery()->getResult();
    }
}