<?php

namespace Pantono\Core\Form;

use Pantono\Core\Container\Application;
use Pantono\Core\Event\Dispatcher;
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

    public function buildForm(FormBuilderInterface $builder, array $options = [])
    {
        $this->setBuilder($builder);
        $this->setOptions($options);
        $this->dispatcher->dispatchFormEvent('pantono.form.prebuild', $this->getName(), $builder);
        $this->buildFormFields();
        $this->dispatcher->dispatchFormEvent('pantono.form.postbuild', $this->getName(), $builder);
    }

    abstract public function buildFormFields();

    /**
     * @return mixed
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
}