<?php

namespace Pantono\Products\Form;

use Pantono\Core\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class Product extends Form
{
    public function buildForm(FormBuilderInterface $builder, array $options = [])
    {
        if ($options) {

        }
        $builder->setAttribute('role', 'form');
        $builder->setAttribute('class', 'product-form');
        $builder->add(
            'title',
            'text',
            [
                'constraints' => [
                    new NotBlank(),
                    new Email()
                ]
            ]
        );
        $builder->add(
            'id',
            'hidden'
        );

        $builder
            ->add(
                'username',
                'email',
                [
                    'constraints' => [
                        new NotBlank(),
                        new Email()
                    ],
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'Username',
                    ],
                    'label' => false
                ]
            )
            ->add(
                'password',
                'password',
                [
                    'constraints' => [
                        new NotBlank(),
                        new Length(['min' => 5])
                    ],
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'Password',
                    ],
                    'label' => false
                ]
            )
            ->add(
                'remember_me',
                'checkbox',
                [
                    'label' => 'Remember Me',
                    'required' => false
                ]
            );
    }
}