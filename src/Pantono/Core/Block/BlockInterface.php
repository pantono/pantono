<?php namespace Pantono\Core\Block;

interface BlockInterface
{
    function render(array $arguments = []);
}