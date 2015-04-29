<?php namespace Pantono\Categories;

use Pantono\Categories\Entity\Repository\CategoryRepository;
use Pantono\Core\Event\Dispatcher;
use Pantono\Categories\Entity\Category as CategoryEntity;

class Category
{
    private $repository;
    private $dispatcher;

    public function __construct(CategoryRepository $repository, Dispatcher $eventDispatcher)
    {
        $this->repository = $repository;
        $this->dispatcher = $eventDispatcher;
    }

    public function addCategory($data)
    {
        $category = new CategoryEntity();
        $category->setTitle($data['title']);
        $category->setDescription($data['description']);
    }
}