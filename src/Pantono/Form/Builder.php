<?php namespace Pantono\Form;

class Builder extends Form
{
    private $config = [];

    public function buildFormFields()
    {
        if (isset($this->config['fields'])) {
            foreach ($this->config['fields'] as $name => $fieldData) {
                $field = $this->getHandlerForType($fieldData['type']);
                $field->setName($name);
                $field->setData($fieldData);
                $this->addElement($field);
            }
        }
    }


    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }
}