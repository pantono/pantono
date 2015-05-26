<?php namespace Pantono\Templates\Model;

class Paginator
{
    private $currentPage;
    private $totalPageCount;
    private $showPages = 5;

    /**
     * @return mixed
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * @param mixed $currentPage
     */
    public function setCurrentPage($currentPage)
    {
        $this->currentPage = $currentPage;
    }

    /**
     * @return mixed
     */
    public function getTotalPageCount()
    {
        return $this->totalPageCount;
    }

    /**
     * @param mixed $totalPageCount
     */
    public function setTotalPageCount($totalPageCount)
    {
        $this->totalPageCount = $totalPageCount;
    }

    /**
     * @return int
     */
    public function getShowPages()
    {
        return $this->showPages;
    }

    /**
     * @param int $showPages
     */
    public function setShowPages($showPages)
    {
        $this->showPages = $showPages;
    }
}
