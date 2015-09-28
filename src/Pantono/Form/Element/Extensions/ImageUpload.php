<?php namespace Pantono\Form\Element\Extensions;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageUpload extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        
    }

    public function getParent()
    {
        return 'hidden';
    }

    public function getName()
    {
        return 'image_upload';
    }

}