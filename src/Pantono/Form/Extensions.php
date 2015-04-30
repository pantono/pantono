<?php

namespace Pantono\Form;

use Pantono\Core\Container\Application;
use Pantono\Core\Event\Dispatcher;
use Pantono\Core\Event\Events\Form as FormEvent;
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
        $items = $this->config->getItem('forms', null, []);
        foreach ($items as $key => $form) {
            $this->dispatcher->dispatchFormEvent(FormEvent::PRE_BUILD, $key, null, $form);
            $formClass = null;
            if (is_string($form)) {
                $formClass = new $form($this->application, $this->dispatcher);
                $formClass->setName($key);
                $forms[] = $formClass;
            }
            if (is_array($form)) {
                $formClass = new Builder($this->application, $this->dispatcher);
                $formClass->setConfig($form);
                $formClass->setName($key);
                $forms[] = $formClass;
            }
            $this->dispatcher->dispatchFormEvent(FormEvent::POST_BUILD, $key, $formClass);
        }
        return $forms;
    }
}