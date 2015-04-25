<?php

namespace Pantono\Acl\Form;

use Pantono\Core\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class Login extends Form
{
    public function buildFormFields()
    {
        $builder = $this->getBuilder();
        $builder->setAttribute('role', 'form');
        $builder->setAttribute('class', 'form-signin');
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