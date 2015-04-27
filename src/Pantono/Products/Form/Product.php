<?php

namespace Pantono\Products\Form;

use Pantono\Core\Form\Element\Hidden;
use Pantono\Core\Form\Element\Text;
use Pantono\Core\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class Product extends Form
{
    public function buildFormFields()
    {
        $this->addAttribute('role', 'form');
        $this->addAttribute('class', 'product-form');
        $title = (new Text())->setName('title')->setLabel('Title')
        ->setConstraints([
            new NotBlank(),
            new Email()
        ]);
        $this->addElement($title);

        $id = (new Hidden())->setName('id');
        $this->addElement($id);
    }
}