<?php namespace Pantono\Form\Element;

use Pantono\Form\Element\Traits\Visible;

class Select extends Element implements ElementInterface
{
    use Visible;
    protected $choices = [];

    public function getType()
    {
        return 'choice';
    }

    /**
     * @return array
     */
    public function getChoices()
    {
        return $this->choices;
    }

    /**
     * @param array $choices
     * @return $this
     */
    public function setChoices($choices)
    {
        $this->choices = $choices;
        return $this;
    }

    public function getOptions()
    {
        $options = [];
        $options = array_merge_recursive($options, $this->getVisibleOptions());
        $options = array_merge_recursive($options, $this->getElementOptions());
        $options['choices'] = $this->getChoices();
        return $options;
    }
}
