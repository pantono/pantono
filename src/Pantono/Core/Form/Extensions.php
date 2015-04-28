<?php


namespace Pantono\Core\Form;

use Pantono\Core\Container\Application;
use Pantono\Core\Event\Dispatcher;
use Pantono\Core\Model\Config\Config;
use Symfony\Component\Form\AbstractExtension;

Class Extensions extends AbstractExtension
{
    private $config;
    private $dispatcher;
    private $application;

    public function __construct(Config $config, Dispatcher $dispatcher, Application $application)
    {
        $this->config = $config;
        $this->dispatcher = $dispatcher;
        $this->application = $application;
    }

    protected function loadTypes()
    {
        $forms = [];

        $items = $this->config->getItem('forms');
        if (!$items) {
            return [];
        }
        foreach ($items as $key => $form) {
            $formClass = new $form($this->application, $this->dispatcher);
            $formClass->setName($key);
            $forms[] = $formClass;
        }
        return $forms;
    }
}