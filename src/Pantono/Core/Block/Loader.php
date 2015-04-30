<?php namespace Pantono\Core\Block;

use Pantono\Core\Container\Application;
use Pantono\Core\Event\Dispatcher;
use Pantono\Core\Model\Block;
use \Pantono\Core\Event\Events\Block as BlockEvent;

class Loader
{
    private $blocks;
    private $eventDispatcher;
    private $blockCache;
    private $application;

    public function __construct(Application $application, Dispatcher $eventDispatcher)
    {
        $this->application = $application;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function addBlock(Block $block)
    {
        $this->eventDispatcher->dispatchBlockEvent(BlockEvent::PRE_LOAD, null, $block);
        $this->blocks[$block->getName()] = $block;
        $this->eventDispatcher->dispatchBlockEvent(BlockEvent::POST_LOAD, null, $block);
    }

    public function renderBlock($name, $arguments)
    {
        $block = $this->getBlockClass($name);
        $this->eventDispatcher->dispatchBlockEvent(BlockEvent::PRE_RENDER, $block, $this->blocks[$name]);
        $contents = $block->doRender($arguments);
        $this->eventDispatcher->dispatchBlockEvent(BlockEvent::PRE_RENDER, $block,  $this->blocks[$name]);
        return $contents;
    }

    /**
     * @param $name
     * @return \Pantono\Core\Block\BlockInterface
     * @throws Exception\BlockNotRegistered
     */
    public function getBlockClass($name)
    {

        if (!isset($this->blockCache[$name])) {
            /**
             * @var $blockModel Block
             */
            $blockModel = isset($this->blocks[$name]) ? $this->blocks[$name] : null;
            if (!$blockModel) {
                throw new Exception\BlockNotRegistered('Block ' . $name . ' called but not registered');
            }
            $className = $blockModel->getClassName();
            $this->blockCache[$name] = new $className($this->application, $this->application->getEventDispatcher());
        }
        return $this->blockCache[$name];
    }
}