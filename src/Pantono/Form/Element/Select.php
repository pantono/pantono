<?php namespace Pantono\Form\Element;

use Pantono\Form\Element\Traits\Visible;

class Select extends Element implements ElementInterface
{
    use Visible;
    protected $choices = [];
    protected $multiple = false;

    public function getType()
    {
        return 'choice';
    }

    /**
     * @return boolean
     */
    public function isMultiple()
    {
        return $this->multiple;
    }

    /**
     * @param boolean $multiple
     */
    public function setMultiple($multiple)
    {
        $this->multiple = $multiple;
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
        if ($this->isMultiple()) {
            $options['multiple'] = true;
        }
        return $options;
    }
}
