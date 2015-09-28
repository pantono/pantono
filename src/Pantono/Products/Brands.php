<?php namespace Pantono\Products;

use Pantono\Core\Event\Manager;
use Pantono\Products\Entity\Repository\ProductRepository;

class Brands
{
    private $repository;
    private $eventManager;

    public function __construct(ProductRepository $repository, Manager $eventManager)
    {
        $this->repository = $repository;
        $this->eventManager = $eventManager;
    }

    /**
     * Gets list of brands
     *
     * @return Entity\Brand[]
     */
    public function getBrandList()
    {
        return $this->repository->getBrandList();
    }

    public function getDropdownList()
    {
        $dropdown = [];
        foreach ($this->getBrandList() as $brand) {
            $dropdown[$brand->getId()] = $brand->getName();
        }
        return $dropdown;
    }
}