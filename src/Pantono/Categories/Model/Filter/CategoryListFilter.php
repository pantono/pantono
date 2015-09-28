<?php namespace Pantono\Categories\Model\Filter;

/**
 * Model for representing a filter used for managing & viewing categories
 *
 * Class CategoryListFilter
 *
 * @package Pantono\Categories\Model\Filter
 * @author  Chris Burton <csburton@gmail.com>
 */
class CategoryListFilter
{
    /**
     * @var string Category name search
     */
    private $search;
    /**
     * @var bool Category active state
     */
    private $active = false;
    /**
     * @var int Parent Category ID
     */
    private $parentId;
    /**
     * @var int Number of categories to show per page
     */
    private $perPage = 20;
    /**
     * @var int Offset to begin showing records at
     */
    private $offset = 0;

    /**
     * Set search string
     *
     * @return string
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * Get search string
     *
     * @param string $search
     */
    public function setSearch($search)
    {
        $this->search = $search;
    }

    /**
     * Sets active state
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Gets active state
     *
     * @param bool $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * Gets parent category id
     *
     * @return int
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Sets parent category id
     *
     * @param int $parentId
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    }

    /**
     * Sets number of results per page
     *
     * @return int
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * Gets number of results per page
     *
     * @param int $perPage
     */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
    }

    /**
     * Gets current offset
     *
     * @return mixed
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * Sets current offset
     *
     * @param mixed $offset
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
    }
}
