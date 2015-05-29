<?php namespace Pantono\Templates\Model\Table;

class Cell
{
    private $attributes;
    private $content;
    private $formatter;
    private $renderedContent;
    private $currency= false;

    /**
     * @param $data
     */
    public function __construct($data)
    {
        $this->setContent($data);
    }

    /**
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param mixed $attributes
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
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFormatter()
    {
        return $this->formatter;
    }

    /**
     * @param mixed $formatter
     * @return $this
     */
    public function setFormatter($formatter)
    {
        $this->formatter = $formatter;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRenderedContent()
    {
        if (!$this->renderedContent) {
            $formatter = $this->getFormatter();
            if (is_object($formatter) && $formatter instanceof \Closure) {
                $this->renderedContent = $formatter($this->getContent());
                return $this->renderedContent;
            }
        }
        return $this->content;
    }

    /**
     * @param mixed $renderedContent
     * @return $this
     */
    public function setRenderedContent($renderedContent)
    {
        $this->renderedContent = $renderedContent;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isCurrency()
    {
        return $this->currency;
    }

    /**
     * @param boolean $currency
     * @return $this;
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }
}
