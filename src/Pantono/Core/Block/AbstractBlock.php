<?php namespace Pantono\Core\Block;

use Pantono\Core\Container\Application;
use Pantono\Core\Event\Dispatcher;

/**
 * Abstract block class, all blocks should extend this class
 *
 * @package Pantono\Core\Block
 * @author  Chris Burton <csburton@gmail.com>
 */
abstract class AbstractBlock implements BlockInterface
{
    /**
     * @var Application
     */
    private $application;

    /**
     * @var Dispatcher
     */
    private $eventDispatcher;

    /**
     * @var string
     */
    private $renderedBlock;

    /**
     * @var string
     */
    private $template;

    /**
     * @param Application $application
     * @param Dispatcher  $eventDispatcher
     */
    public function __construct(Application $application, Dispatcher $eventDispatcher)
    {
        $this->application = $application;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function render(array $arguments = []);

    public function doRender(array $arguments = [])
    {
        $this->setRenderedBlock($this->render());
        return $this->getRenderedBlock();
    }

    /**
     * Gets rendered block
     *
     * @return string
     */
    public function getRenderedBlock()
    {
        return $this->renderedBlock;
    }

    /**
     * Sets block
     *
     * @param string $renderedBlock
     */
    public function setRenderedBlock($renderedBlock)
    {
        $this->renderedBlock = $renderedBlock;
    }

    /**
     * Returns current application container class
     *
     * @return Application
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * Returns event dispatcher class
     *
     * @return Dispatcher
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    /**
     * Sets event dispatcher
     *
     * @param Dispatcher $eventDispatcher
     */
    public function setEventDispatcher($eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Gets block template file as a string
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Sets template filename
     *
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }
}
