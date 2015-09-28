<?php namespace Pantono\Templates\Model\Table;

class Action
{
    private $url;
    private $classes;
    private $attributes = [];

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClasses()
    {
        return $this->classes;
    }

    /**
     * @param mixed $classes
     * @return $this
     */
    public function setClasses($classes)
    {
        $this->classes = $classes;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     *
     * @return $this
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    public function addAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
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
