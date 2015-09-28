<?php namespace Pantono\Products;

use Pantono\Core\Event\Manager;
use Pantono\Products\Entity\Repository\ProductRepository;

class Condition
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
     * @return Entity\Condition[]
     */
    public function getConditionList()
    {
        return $this->repository->getConditionList();
    }

    public function getDropdownList()
    {
        $dropdown = [];
        foreach ($this->getConditionList() as $brand) {
            $dropdown[$brand->getId()] = $brand->getName();
        }
        return $dropdown;
    }
}