<?php namespace Pantono\Templates\Model\Table;

class Action
{
    private $url;
    private $classes;
    private $attributes;

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getClasses()
    {
        return $this->classes;
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
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    public function addAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    /**
     * @param mixed $classes
     */
    public function setClasses($classes)
    {
        $this->classes = $classes;
    }

    public function __toString()
    {
        $string = '<a ';
        foreach ($this->getAttributes() as $attribute => $value) {
            $string .= $attribute . '="' . $value . '" ';
        }
        $string .= 'class="' . $this->getClasses() . '" ';
        $string .= 'href="' . $this->getUrl() . '">';
        $string .= '</a>';
        return $string;
    }
}