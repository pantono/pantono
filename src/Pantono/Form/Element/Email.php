<?php namespace Pantono\Form\Element;

use Pantono\Form\Element\Traits\Visible;

class Email extends Element implements ElementInterface
{
    use Visible;

    public function getType()
    {
        return 'email';
    }

    public function getOptions()
    {
        $options = [];
        $options = array_merge_recursive($options, $this->getVisibleOptions());
        $options = array_merge_recursive($options, $this->getElementOptions());
        return $options;
    }
}
