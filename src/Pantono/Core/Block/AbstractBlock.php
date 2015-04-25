<?php namespace Pantono\Core\Block;

use Pantono\Core\Block\BlockInterface;
use Pantono\Core\Container\Application;
use Pantono\Core\Event\Dispatcher;
use Pantono\Core\Event\Manager;

abstract class AbstractBlock implements BlockInterface
{
    private $application;
    private $eventDispatcher;
    private $renderedBlock;
    private $template;

    public function __construct(Application $application, Dispatcher $eventDispatcher)
    {
        $this->application = $application;
        $this->eventDispatcher = $eventDispatcher;
    }

    abstract public function render(array $arguments = []);

    public function doRender()
    {
        $this->setRenderedBlock($this->render());
        return $this->getRenderedBlock();
    }

    /**
     * @return string
     */
    public function getRenderedBlock()
    {
        return $this->renderedBlock;
    }

    /**
     * @param string $renderedBlock
     */
    public function setRenderedBlock($renderedBlock)
    {
        $this->renderedBlock = $renderedBlock;
    }

    /**
     * @return Application
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @return Dispatcher
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    /**
     * @param Dispatcher $eventDispatcher
     */
    public function setEventDispatcher($eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param mixed $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }
}