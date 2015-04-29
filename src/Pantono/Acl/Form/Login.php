<?php

namespace Pantono\Acl\Form;

use Pantono\Form\Element\Checkbox;
use Pantono\Form\Element\Email;
use Pantono\Form\Element\Password;
use Pantono\Form\Element\Text;
use Pantono\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class Login extends Form
{
    public function buildFormFields()
    {
        $username = (new Email())->setName('username')
            ->setClass('form-control')
            ->setPlaceholder('Username')
            ->setConstraints([new NotBlank(), new EmailConstraint()])
            ->setLabel(false)
            ->setWeight(10);
        $this->addElement($username);

        $password = (new Password())
            ->setName('password')
            ->setConstraints([
                new NotBlank(),
                new Length(['min' => 5])
            ])
            ->setClass('form-control')
            ->setPlaceholder('Password')
            ->setLabel(false)
            ->setWeight(20);
        $this->addElement($password);
        $checkbox = (new Checkbox())
            ->setName('remember_me')
            ->setLabel('Remember Me')
            ->setRequired(false);
        $this->addElement($checkbox);
        $this->setAction('');
        $this->addAttribute('role', 'form');
        $this->addAttribute('class', 'form-signin');
    }
}