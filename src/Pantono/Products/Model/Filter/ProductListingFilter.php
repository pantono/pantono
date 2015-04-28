<?php namespace Pantono\Products\Model\Filter;

class ProductListingFilter
{
    protected $name;
    protected $priceMin;
    protected $priceMax;
    protected $brand;
    protected $supplier;
    protected $dateCreatedStart;
    protected $dateCreatedEnd;
    protected $condition;
    protected $pageNumber;
    protected $perPage;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPriceMin()
    {
        return $this->priceMin;
    }

    /**
     * @param mixed $priceMin
     */
    public function setPriceMin($priceMin)
    {
        $this->priceMin = $priceMin;
    }

    /**
     * @return mixed
     */
    public function getPriceMax()
    {
        return $this->priceMax;
    }

    /**
     * @param mixed $priceMax
     */
    public function setPriceMax($priceMax)
    {
        $this->priceMax = $priceMax;
    }

    /**
     * @return mixed
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param mixed $brand
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    /**
     * @return mixed
     */
    public function getSupplier()
    {
        return $this->supplier;
    }

    /**
     * @param mixed $supplier
     */
    public function setSupplier($supplier)
    {
        $this->supplier = $supplier;
    }

    /**
     * @return mixed
     */
    public function getDateCreatedStart()
    {
        return $this->dateCreatedStart;
    }

    /**
     * @param mixed $dateCreatedStart
     */
    public function setDateCreatedStart($dateCreatedStart)
    {
        $this->dateCreatedStart = $dateCreatedStart;
    }

    /**
     * @return mixed
     */
    public function getDateCreatedEnd()
    {
        return $this->dateCreatedEnd;
    }

    /**
     * @param mixed $dateCreatedEnd
     */
    public function setDateCreatedEnd($dateCreatedEnd)
    {
        $this->dateCreatedEnd = $dateCreatedEnd;
    }

    /**
     * @return mixed
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @param mixed $condition
     */
    public function setCondition($condition)
    {
        $this->condition = $condition;
    }

    /**
     * @return mixed
     */
    public function getPageNumber()
    {
        return $this->pageNumber;
    }

    /**
     * @param mixed $pageNumber
     */
    public function setPageNumber($pageNumber)
    {
        $this->pageNumber = $pageNumber;
    }

    /**
     * @return mixed
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * @param mixed $perPage
     */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
    }
}