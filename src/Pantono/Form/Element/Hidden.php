<?php namespace Pantono\Form\Element;

class Hidden extends Element implements ElementInterface
{
    public function getType()
    {
        return 'hidden';
    }

    public function getOptions()
    {
        $options = [];
        $options = array_merge_recursive($options, $this->getElementOptions());
        return $options;
    }
}
