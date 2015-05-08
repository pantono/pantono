<?php namespace Pantono\Form;

class Builder extends Form
{
    private $config = [];

    public function buildFormFields()
    {
        $this->setEntity();
        foreach ($this->getFields() as $name => $fieldData) {
            $this->getDispatcher()->dispatchFormFieldEvent('pantono.formfield.prebuild', $this->getName(), $name, $fieldData);
            $field = $this->getHandlerForType($fieldData['type']);
            $field->setName($name);
            $field->setData($fieldData);

            $app = $this->getApplication();
            if (isset($fieldData['choice_populator'])) {
                $populator = $fieldData['choice_populator'];
                list($service, $method) = explode('::', $populator);
                $field->setChoices($app->getPantonoService($service)->$method());
            }
            $this->getDispatcher()->dispatchFormFieldEvent('pantono.formfield.postbuild', $this->getName(), $name, $fieldData, $field);
            $this->addElement($field);

        }
    }

    public function getFields()
    {
        if (!isset($this->config['fields'])) {
            return [];
        }
        return $this->config['fields'];
    }

    private function setEntity()
    {
        if (isset($this->getConfig()['entity'])) {
            $this->setEntityClassName($this->getConfig()['entity']);
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