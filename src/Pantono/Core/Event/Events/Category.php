<?php namespace Pantono\Core\Event\Events;

class Category extends General
{
    private $data;
    private $categoryEntity;
    const PRE_HYDRATE = 'pantono.category.pre-hydrate';
    const PRE_SAVE = 'pantono.category.pre-save';
    const POST_SAVE = 'pantono.category.post-save';

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return \Pantono\Categories\Entity\Category
     */
    public function getCategoryEntity()
    {
        return $this->categoryEntity;
    }

    /**
     * @param mixed $categoryEntity
     */
    public function setCategoryEntity(\Pantono\Categories\Entity\Category $categoryEntity = null)
    {
        $this->categoryEntity = $categoryEntity;
    }
}