<?php namespace Pantono\Core\Event\Events;


class FormField extends General
{
    private $formName;
    private $fieldName;
    private $fieldData;
    private $element;

    /**
     * @return mixed
     */
    public function getFormName()
    {
        return $this->formName;
    }

    /**
     * @param mixed $formName
     */
    public function setFormName($formName)
    {
        $this->formName = $formName;
    }

    /**
     * @return mixed
     */
    public function getFieldName()
    {
        return $this->fieldName;
    }

    /**
     * @param mixed $fieldName
     */
    public function setFieldName($fieldName)
    {
        $this->fieldName = $fieldName;
    }

    /**
     * @return mixed
     */
    public function getFieldData()
    {
        return $this->fieldData;
    }

    /**
     * @param mixed $fieldData
     */
    public function setFieldData($fieldData)
    {
        $this->fieldData = $fieldData;
    }

    /**
     * @return mixed
     */
    public function getElement()
    {
        return $this->element;
    }

    /**
     * @param mixed $element
     */
    public function setElement($element)
    {
        $this->element = $element;
    }
}