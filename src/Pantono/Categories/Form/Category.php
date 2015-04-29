<?php namespace Pantono\Categories\Form;

use Pantono\Form\Element\File;
use Pantono\Form\Element\Select;
use Pantono\Form\Element\Text;
use Pantono\Form\Element\Textarea;
use Pantono\Form\Form;

class Category extends Form
{
    public function buildFormFields()
    {
        $this->addAttribute('role', 'form');
        $parent = (new Select())->setName('parent')
            ->setChoices([
                '0' => ' - Top Level - '
            ])
            ->setLabel('Parent Category');
        $this->addElement($parent);
        $title = (new Text())->setName('title')
            ->setLabel('Title');
        $this->addElement($title);
        $urlKey = (new Text())->setName('url_key')
            ->setLabel('URL Key')
            ->setReadonly(true);
        $this->addElement($urlKey);
        $description = (new Textarea())->setName('description')
            ->setLabel('Description');
        $this->addElement($description);
        $image = (new File())->setName('image')
            ->setLabel('Image');
        $this->addElement($image);
    }
}