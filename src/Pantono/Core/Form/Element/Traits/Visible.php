<?php namespace Pantono\Core\Form\Element\Traits;

trait Visible
{
    protected $label;
    protected $labelAttributes = [];
    protected $readonly = false;
    protected $disabled = false;
    protected $placeholder;

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return array
     */
    public function getLabelAttributes()
    {
        return $this->labelAttributes;
    }

    /**
     * @param array $labelAttributes
     * @return $this
     */
    public function setLabelAttributes(array $labelAttributes)
    {
        $this->labelAttributes = $labelAttributes;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isReadonly()
    {
        return $this->readonly;
    }

    /**
     * @param boolean $readonly
     * @return $this
     */
    public function setReadonly($readonly)
    {
        $this->readonly = $readonly;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isDisabled()
    {
        return $this->disabled;
    }

    /**
     * @param boolean $disabled
     * @return $this
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * @param mixed $placeholder
     * @return $this
     */
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function getVisibleOptions()
    {
        $options = [];
        if ($this->isReadonly()) {
            $options['read_only'] = true;
        }
        $options['label'] = $this->getLabel();
        if ($this->isDisabled() !== null) {
            $options['disabled'] = $this->isDisabled();
        }
        $options['label_attr'] = $this->getLabelAttributes();
        if ($this->getPlaceholder()) {
            $options['attr']['placeholder'] = $this->getPlaceholder();
        }
        return $options;
    }

}