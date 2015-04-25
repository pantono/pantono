<?php


namespace Pantono\Core\Form;

use Pantono\Core\Container\Application;
use Pantono\Core\Event\Dispatcher;
use Symfony\Component\Form\AbstractExtension;

Class Extensions extends AbstractExtension
{
    private $config;
    private $dispatcher;
    private $application;

    public function __construct(array $config, Dispatcher $dispatcher, Application $application)
    {
        $this->config = $config;
        $this->dispatcher = $dispatcher;
        $this->application = $application;
    }

    protected function loadTypes()
    {
        $forms = [];
        if (!isset($this->config['forms'])) {
            return [];
        }
        foreach ($this->config['forms'] as $key => $form) {
            $formClass = new $form($this->application, $this->dispatcher);
            $formClass->setName($key);
            $forms[] = $formClass;
        }
        return $forms;
    }
}