<?php namespace Pantono\Core\Event\Events;

class Block extends General
{
    private $block;
    private $contents;
    private $blockModel;
    const PRE_LOAD = 'pantono.block.pre-load';
    const POST_LOAD = 'pantono.block.post-load';
    const PRE_RENDER = 'pantono.block.pre-render';
    const POST_RENDER = 'pantono.block.post-render';

    /**
     * @return mixed
     */
    public function getBlock()
    {
        return $this->block;
    }

    /**
     * @param mixed $block
     */
    public function setBlock($block)
    {
        $this->block = $block;
    }

    /**
     * @return mixed
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * @param mixed $contents
     */
    public function setContents($contents)
    {
        $this->contents = $contents;
    }

    /**
     * @return mixed
     */
    public function getBlockModel()
    {
        return $this->blockModel;
    }

    /**
     * @param mixed $blockModel
     */
    public function setBlockModel($blockModel)
    {
        $this->blockModel = $blockModel;
    }
}
