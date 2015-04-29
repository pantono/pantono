<?php namespace Pantono\Form\Element;

use Pantono\Form\Exception\ConstraintNotRegistered;

abstract class Element
{
    protected $name;
    protected $id;
    protected $class;
    protected $placeholder;
    protected $weight;
    protected $defaultValue;
    protected $required = false;
    protected $constraints;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param mixed $class
     * @return $this
     */
    public function setClass($class)
    {
        $this->class = $class;
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

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     * @return $this
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * @param mixed $defaultValue
     * @return $this
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * @param boolean $required
     * @return $this
     */
    public function setRequired($required)
    {
        $this->required = $required;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getConstraints()
    {
        return $this->constraints;
    }

    /**
     * @param mixed $constraints
     * @return $this
     */
    public function setConstraints($constraints)
    {
        $this->constraints = $constraints;
        return $this;
    }

    public function addConstraint($constraint)
    {
        $this->constraints[] = $constraint;
        return $this;
    }

    public function getElementOptions()
    {
        $options = [];
        $options['attr']['class'] = $this->getClass();
        if ($this->getDefaultValue()) {
            $options['data'] = $this->getDefaultValue();
        }
        if ($this->isRequired() !== null) {
            $options['required'] = $this->isRequired();
        }
        return $options;
    }

    public function setData(array $data)
    {
        foreach ($data as $key => $value) {
            if ($key === 'constraints') {
                $this->addConstraints($value);
                continue;
            }
            if (property_exists($this, $key)) {
                $key = str_replace('_', ' ', $key);
                $key = ucwords($key);
                $key = str_replace(' ', '', $key);
                $setter = 'set' . $key;
                $this->{$setter}($value);
            }
        }
    }

    public function addConstraints(array $constraints)
    {
        foreach ($constraints as $constraint) {
            $this->addConstraint($this->generateConstraint($constraint));
        }
    }

    /**
     * @param $constraint
     * @return array
     * @throws ConstraintNotRegistered
     */
    public function generateConstraint($constraint)
    {
        $class = $constraint;
        $arguments = [];
        if (is_array($constraint)) {
            $keys = array_keys($constraint);
            $class = $keys[0];
            $arguments = $constraint[$class];
        }
        if (!class_exists($class)) {
            throw new ConstraintNotRegistered('Constraint ' . $constraint . ' is not registered');
        }
        return new $class($arguments);
    }
}