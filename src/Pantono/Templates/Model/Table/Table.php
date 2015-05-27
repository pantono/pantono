<?php namespace Pantono\Templates\Model\Table;

class Table
{
    private $attributes;
    private $headers;
    private $rows;
    private $paginator;
    private $renderedContent;


    public function addAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    public function getAttribute($name)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }

    public function appendToAttribute($name, $value)
    {
        if (isset($this->attributes[$name])) {
            $this->attributes[$name] .= $value;
            return true;
        }
        $this->addAttribute($name, $value);
    }

    /**
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param $attributes
     * @return $this
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    public function addHeader($name)
    {
        $this->headers[] = $name;
    }

    /**
     * @param mixed $headers
     * @return $this
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @return Row[]
     */
    public function getRows()
    {
        return $this->rows;
    }

    public function addRow(Row $row)
    {
        $this->rows[] = $row;
    }

    /**
     * @param mixed $rows
     * @return $this
     */
    public function setRows($rows)
    {
        $this->rows = $rows;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaginator()
    {
        return $this->paginator;
    }

    /**
     * @param mixed $paginator
     * @return $this
     */
    public function setPaginator($paginator)
    {
        $this->paginator = $paginator;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRenderedContent()
    {
        return $this->renderedContent;
    }

    /**
     * @param mixed $renderedContent
     */
    public function setRenderedContent($renderedContent)
    {
        $this->renderedContent = $renderedContent;
    }

    public function hasActions()
    {
        foreach ($this->getRows() as $row) {
            if ($row->hasActions()) {
                return true;
            }
        }
        return false;
    }
}
