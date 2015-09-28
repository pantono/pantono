<?php

namespace Pantono\Core\Block;

/**
 * Provides interface for utiliting blocks throughout Pantono
 *
 * Interface BlockInterface
 *
 * @package Pantono\Core\Block
 * @author  Chris Burton <csburton@gmail.com>
 */
interface BlockInterface
{
    /**
     * Method to get the output of a block
     *
     * @param array $arguments Block Arguments
     *
     * @return string
     */
    public function render(array $arguments = []);

    /**
     * Method that wraps around the render method, will generally fire off events based around
     * the blocks
     *
     * @param array $arguments Block Arguments
     *
     * @return string
     */
    public function doRender(array $arguments = []);
}
