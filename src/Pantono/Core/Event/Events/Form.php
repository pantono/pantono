<?php namespace Pantono\Core\Event\Events;

use Symfony\Component\Form\FormBuilderInterface;

class Form extends General
{
    private $name;
    private $builder;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param FormBuilderInterface $builder
     */
    public function setBuilder(FormBuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @return FormBuilderInterface
     */
    public function getBuilder()
    {
        return $this->builder;
    }
}