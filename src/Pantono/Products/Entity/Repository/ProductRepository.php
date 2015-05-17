<?php namespace Pantono\Products\Entity\Repository;

use Pantono\Products\Entity\Product;
use Doctrine\ORM\EntityRepository;
use Pantono\Products\Model\Filter\ProductListingFilter;

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
        $qb->select('p', 'd')
            ->from('Pantono\Products\Entity\Product', 'p')
            ->leftJoin('p.draft', 'd');
        if ($filter->getName()) {
            $qb->where('p.name like :name')
                ->setParameter('name', '%' . $filter->getName() . '%');
        }
        if ($filter->getSupplier() > 0) {
            $qb->where('p.supplier = :supplier', $this->_em->getReference('Pantono\Suppliers\Entity\Supplier', $filter->getSupplier()));
        }
        return $qb->getQuery()->getResult();
    }
}
