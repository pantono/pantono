<?php


namespace Csburton\SilEcom\Core\Form;

use Csburton\SilEcom\Acl\Form\Login;
use Csburton\SilEcom\Core\Model\Config\Config;
use Symfony\Component\Form\AbstractExtension;

Class Extensions extends AbstractExtension
{
    private $config;
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    protected function loadTypes()
    {
        $forms = [];
        if (!isset($this->config['forms'])) {
            return [];
        }
        foreach ($this->config['forms'] as $key => $form) {
            $formClass = new $form;
            $formClass->setName($key);
            $forms[] = $formClass;
        }
        return $forms;
    }
}