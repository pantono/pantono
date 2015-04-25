<?php namespace Pantono\Categories\Form;

use Pantono\Core\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class Category extends Form
{
    public function buildFormFields(FormBuilderInterface $builder, array $options = [])
    {

    }
}