<?php namespace Pantono\Core\Form;
use Symfony\Component\Form\FormBuilderInterface;
trait Elements
{

    /**
     * @return FormBuilderInterface
     */
    abstract public function getBuilder();

    /**
     * @param $name
     * @param array $classes
     * @param $options
     */
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