<?php namespace Pantono\Core\Event\Events\Block;

use Pantono\Core\Block\BlockInterface;
use Pantono\Core\Event\Events\General;

abstract class AbstractBlockEvent extends General
{
    protected $block;

    public function setBlock(BlockInterface $block)
    {
        $this->block = $block;
    }

    public function getBlock()
    {
        return $this->block;
    }
}
