<?php namespace Pantono\Core\Model;

class Block
{
    private $name;
    private $className;
    private $cacheable = true;
    private $cacheLength = 1800;
    private $template;

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
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param mixed $className
     */
    public function setClassName($className)
    {
        $this->className = $className;
    }

    /**
     * @return boolean
     */
    public function isCacheable()
    {
        return $this->cacheable;
    }

    /**
     * @param boolean $cacheable
     */
    public function setCacheable($cacheable)
    {
        $this->cacheable = $cacheable;
    }

    /**
     * @return int
     */
    public function getCacheLength()
    {
        return $this->cacheLength;
    }

    /**
     * @param int $cacheLength
     */
    public function setCacheLength($cacheLength)
    {
        $this->cacheLength = $cacheLength;
    }

    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param mixed $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }
}
