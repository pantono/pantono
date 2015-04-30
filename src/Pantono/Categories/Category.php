<?php namespace Pantono\Categories;

use Pantono\Categories\Entity\Repository\CategoryRepository;
use Pantono\Categories\Model\Filter\CategoryListFilter;
use Pantono\Core\Entity\Hydrator\EntityHydrator;
use Pantono\Core\Event\Dispatcher;
use Pantono\Categories\Entity\Category as CategoryEntity;
use \Pantono\Core\Event\Events\Category as CategoryEvent;

class Category
{
    private $repository;
    private $dispatcher;
    private $hydrator;

    public function __construct(CategoryRepository $repository, Dispatcher $eventDispatcher, EntityHydrator $hydrator)
    {
        $this->repository = $repository;
        $this->dispatcher = $eventDispatcher;
        $this->hydrator = $hydrator;
    }

    public function addCategory($data)
    {
        $this->dispatcher->dispatchCategoryEvent(CategoryEvent::PRE_HYDRATE, $data);
        /**
         * @var $category \Pantono\Categories\Entity\Category
         */
        $category = $this->hydrator->hydrate('Pantono\Categories\Entity\Category', $data);
        if (!$category->getUrlKey()) {
            $category->setUrlKey($this->getUniqueUrlKey($category->getTitle()));
        }
        $this->dispatcher->dispatchCategoryEvent(CategoryEvent::PRE_SAVE, $data, $category);
        $this->repository->save($category);
        $this->repository->flush();
        $this->dispatcher->dispatchCategoryEvent(CategoryEvent::POST_SAVE, $data, $category);
        return $category;
    }

    public function getUniqueUrlKey($title, $index = 0)
    {
        if ($index > 0) {
            $url = \URLify::filter($title.'-'.$index);
        } else {
            $url = \URLify::filter($title);
        }
        if ($this->repository->getCategoryByUrlKey($url)) {
            return $this->getUniqueUrlKey($title, ($index + 1));
        }
        return $url;
    }

    public function getCategoryList(CategoryListFilter $filter)
    {
        $categories = $this->repository->getCategoryList($filter);
        if (!is_array($categories)) {
            return [];
        }
        return $categories;
    }

    public function getCategoryListTree()
    {
        $filter = new CategoryListFilter();
        $filter->setActive(true);
        $categories = [];
        foreach ($this->getCategoryList($filter) as $category) {
            $categories[$category->getId()] = $category->getBreadcrumb();
        }
        return $categories;
    }
}