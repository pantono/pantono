<?php namespace Pantono\Core\Block;

use Pantono\Core\Container\Application;
use Pantono\Core\Event\Dispatcher;
use Pantono\Core\Model\Block;

class Loader
{
    private $blocks;
    private $eventDispatcher;
    private $blockCache;

    public function __construct(Application $application, Dispatcher $eventDispatcher)
    {
        $this->application = $application;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function addBlock(Block $block)
    {
        $this->blocks[$block->getName()] = $block;
    }

    public function renderBlock($name, $arguments)
    {
        $block = $this->getBlockClass($name);
        $this->eventDispatcher->dispatchBlockEvent('pantono.block.prerender', $block);
        $contents = $block->doRender($arguments);
        $this->eventDispatcher->dispatchBlockEvent('pantono.block.postrender', $block);
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
            $blockModel = isset($this->blocks[$name])?$this->blocks[$name]:null;
            if (!$blockModel) {
                throw new Exception\BlockNotRegistered('Block '.$name.' called but not registered');
            }
            $className = $blockModel->getClassName();
            $this->blockCache[$name] = new $className($this->application, $this->application->getEventDispatcher());
        }
        return $this->blockCache[$name];
    }
}