<?php

namespace Pantono\Core\Form;

use Pantono\Core\Container\Application;
use Pantono\Core\Event\Dispatcher;
use Pantono\Core\Form\Element\ElementInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;

abstract class Form extends AbstractType
{
    private $name;
    private $application;
    private $dispatcher;
    private $builder;
    private $options;
    private $elements;
    private $action;
    private $attributes;
    private $method;

    public function __construct(Application $application, Dispatcher $dispatcher)
    {
        $this->application = $application;
        $this->dispatcher = $dispatcher;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function addElement(ElementInterface $element)
    {
        if (!$this->getBuilder() instanceof FormBuilderInterface) {
            throw new \Exception(get_class($this).'::buildFormFields needs to be called before adding an element');
        }
        $this->elements[] = $element;
    }

    public function getElements()
    {
        return $this->elements;
    }

    public function buildForm(FormBuilderInterface $builder, array $options = [])
    {
        $this->setBuilder($builder);
        $this->setOptions($options);
        $this->dispatcher->dispatchFormEvent('pantono.form.prebuild', $this->getName(), $builder);
        $this->buildFormFields();
        foreach ($this->getAttributes() as $name => $value) {
            $builder->setAttribute($name, $value);
        }
        foreach ($this->getElements() as $element)
        {
            $builder->add(
                $element->getName(),
                $element->getType(),
                $element->getOptions()
            );
        }
        $this->dispatcher->dispatchFormEvent('pantono.form.postbuild', $this->getName(), $builder);
    }

    abstract public function buildFormFields();

    /**
     * @return FormBuilderInterface
     */
    public function getBuilder()
    {
        return $this->builder;
    }

    /**
     * @param mixed $builder
     */
    public function setBuilder($builder)
    {
        $this->builder = $builder;
    }

    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param mixed $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param mixed $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    public function addAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }
}