<?php namespace Pantono\Core\Event\Events;

use Symfony\Component\Form\FormBuilderInterface;

class Form extends General
{
    private $formName;
    private $builder;

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