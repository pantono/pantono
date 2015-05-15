<?php namespace Pantono\Core\Event\Events;

use Symfony\Component\Form\FormBuilderInterface;

class Form extends General
{
    private $formName;
    private $builder;
    private $data;

    const PRE_LOAD = 'pantono.form.pre-load';
    const POST_LOAD = 'pantono.form.post-load';
    const PRE_BUILD = 'pantono.form.pre-build';
    const POST_BUILD = 'pantono.form.post-build';
    const PRE_HYDRATE = 'pantono.form.pre-populate';
    const POST_HYDRATE = 'pantono.form.post-populate';

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
    public function setBuilder($builder = null)
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

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}
