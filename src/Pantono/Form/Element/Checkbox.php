<?php namespace Pantono\Form\Element;

use Pantono\Form\Element\Traits\Visible;

class Checkbox extends Element implements ElementInterface
{
    use Visible;

    public function getType()
    {
        return 'checkbox';
    }

    public function getOptions()
    {
        $options = [];
        $options = array_merge_recursive($options, $this->getVisibleOptions());
        $options = array_merge_recursive($options, $this->getElementOptions());
        return $options;
    }
}