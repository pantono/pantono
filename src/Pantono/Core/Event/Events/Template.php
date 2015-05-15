<?php

namespace Pantono\Core\Event\Events;

use Symfony\Component\EventDispatcher\Event;

class Template extends Event
{
    private $content;
    private $controller;
    private $action;
    private $templateFile;

    const PRE_RENDER = 'pantono.template.prerender';
    const POST_RENDER = 'pantono.template.postrender';

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(&$content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param mixed $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getTemplateFile()
    {
        return $this->templateFile;
    }

    /**
     * @param mixed $templateFile
     */
    public function setTemplateFile(&$templateFile)
    {
        $this->templateFile = $templateFile;
    }
}
