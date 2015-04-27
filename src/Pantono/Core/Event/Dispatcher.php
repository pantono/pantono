<?php

namespace Pantono\Core\Event;

use Pantono\Core\Block\BlockInterface;
use Pantono\Core\Container\Application;
use Pantono\Core\Event\Events\Block;
use Pantono\Core\Event\Events\Form;
use Pantono\Core\Event\Events\General;
use Pantono\Core\Event\Events\Template;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Form\FormBuilderInterface;

class Dispatcher
{
    private $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function dispatchGeneralEvent($event)
    {
        $this->application['dispatcher']->dispatch($event, new General($this->application));
    }

    public function dispatchTemplateEvent($event, &$templateFile, &$templateContent, $controller, $action)
    {
        $templateEvent = new Template();
        $templateEvent->setContent($templateContent);
        $templateEvent->setTemplateFile($templateFile);
        $templateEvent->setController($controller);
        $templateEvent->setAction($action);
        $this->application['dispatcher']->dispatch($event, $templateEvent);
    }

    public function dispatchBlockEvent($event, BlockInterface $block)
    {
        $blockEvent = new Block($this->application);
        $blockEvent->setBlock($block);
        $this->application['dispatcher']->dispatch($event, $blockEvent);
    }

    public function dispatchFormEvent($event, $formName, FormBuilderInterface $builder)
    {
        $formEvent = new Form($this->application);
        $formEvent->setBuilder($builder);
        $formEvent->setName($formName);
        $this->application['dispatcher']->dispatch($event, $formEvent);
    }
}