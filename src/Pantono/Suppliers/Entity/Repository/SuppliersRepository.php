<?php namespace Pantono\Suppliers\Entity\Repository;

use Pantono\Database\Repository\AbstractRepository;

class SuppliersRepository extends AbstractRepository
{
    /**
     * @return \Pantono\Suppliers\Entity\Supplier[]
     */
    public function getSupplierList()
    {
        return $this->_em->getRepository('Pantono\Suppliers\Entity\Supplier')->findAll();
    }
}