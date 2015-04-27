<?php namespace Pantono\Core\Event\Events;

use Symfony\Component\Form\FormBuilderInterface;

class Form extends General
{
    private $builder;

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