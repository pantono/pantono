<?php namespace Pantono\Categories;

use Pantono\Assets\Assets;
use Pantono\Categories\Entity\Repository\CategoryRepository;
use Pantono\Categories\Exception\CategoryNotFound;
use Pantono\Categories\Model\Filter\CategoryListFilter;
use Pantono\Core\Entity\Hydrator\EntityHydrator;
use Pantono\Core\Event\Dispatcher;
use Pantono\Categories\Entity\Category as CategoryEntity;
use \Pantono\Core\Event\Events\Category as CategoryEvent;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Category
{
    private $repository;
    private $dispatcher;
    private $hydrator;
    private $assets;

    public function __construct(CategoryRepository $repository, Dispatcher $eventDispatcher, EntityHydrator $hydrator, Assets $assets)
    {
        $this->repository = $repository;
        $this->dispatcher = $eventDispatcher;
        $this->hydrator = $hydrator;
        $this->assets = $assets;
    }

    public function getCategoryById($id, $flat = false)
    {
        $category = $this->repository->find($id);
        if ($category === null) {
            throw new CategoryNotFound('Category with id ' . $id . ' cannot be found');
        }
        if ($flat) {
            return $this->hydrator->deHydrate($category);
        }
        return $category;
    }

    public function saveCategory($data)
    {
        $this->dispatcher->dispatchCategoryEvent(CategoryEvent::PRE_HYDRATE, $data);
        if ($data['image'] instanceof UploadedFile) {
            $asset = $this->assets->uploadAsset($data['image']);
            $data['image'] = $asset->getId();
        }
        $currentEntity = null;
        if (isset($data['id'])) {
            $currentEntity = $this->getCategoryById($data['id']);
        }
        /**
         * @var $category \Pantono\Categories\Entity\Category
         */
        $category = $this->hydrator->hydrate('Pantono\Categories\Entity\Category', $data, $currentEntity);
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
        $url = \URLify::filter($title);
        if ($index > 0) {
            $url = \URLify::filter($title . '-' . $index);
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