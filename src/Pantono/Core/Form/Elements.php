<?php namespace Pantono\Core\Form;

trait Elements
{
    public function addTextField($name, $classes = [], $options)
    {
        $options['attr']['class'] .= $classes;
        $this->getBuilder()->add(
            $name,
            'text',
            $options
        );
    }

    public function addSelectField($name, $choices, $classes = [], $options = [])
    {
        $options['attr']['class'] .= $classes;
        $options['choices'] = $choices;
        $this->getBuilder()->add(
            $name,
            'choice',
            $options
        );
    }
}