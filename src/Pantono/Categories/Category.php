<?php namespace Pantono\Categories;

use Pantono\Assets\Assets;
use Pantono\Categories\Entity\Repository\CategoryRepository;
use Pantono\Categories\Exception\CategoryNotFound;
use Pantono\Categories\Model\Filter\CategoryListFilter;
use Pantono\Core\Event\Dispatcher;
use \Pantono\Core\Event\Events\Category as CategoryEvent;
use Pantono\Metadata\Metadata;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Category
{
    private $repository;
    private $dispatcher;
    private $assets;
    private $metadata;

    public function __construct(CategoryRepository $repository, Dispatcher $eventDispatcher, Assets $assets, Metadata $metadata)
    {
        $this->repository = $repository;
        $this->dispatcher = $eventDispatcher;
        $this->assets = $assets;
        $this->metadata = $metadata;
    }

    public function getCategoryById($id)
    {
        $category = $this->repository->find($id);
        if ($category === null) {
            throw new CategoryNotFound('Category with id ' . $id . ' cannot be found');
        }
        return $category;
    }

    public function uploadImage($data)
    {
        if ($data instanceof UploadedFile) {
            $asset = $this->assets->uploadAsset($data['image']);
            return $asset->getId();
        }
        return null;
    }

    public function saveCategoryEntity(\Pantono\Categories\Entity\Category $category)
    {
        if ($category->getMetadata() !== null) {
            $metadata = $this->metadata->saveMetadata($category->getMetadata());
            $category->setMetadata($metadata);
        }
        if (!$category->getMetadata() === null) {
            $category->setMetadata(new \Pantono\Metadata\Entity\Metadata());
        }
        if (!$category->getUrlKey()) {
            $category->setUrlKey($this->getUniqueUrlKey($category->getTitle()));
        }
        $this->dispatcher->dispatchCategoryEvent(CategoryEvent::PRE_SAVE, [], $category);
        $this->repository->save($category);
        $this->repository->flush();
        $this->dispatcher->dispatchCategoryEvent(CategoryEvent::POST_SAVE, [], $category);
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
