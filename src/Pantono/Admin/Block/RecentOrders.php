<?php namespace Pantono\Admin\Block;

use Pantono\Core\Block\BlockInterface;
use Pantono\Core\Block\AbstractBlock;

/**
 * Block which will render recent orders
 *
 * Class RecentOrders
 *
 * @package Pantono\Admin\Block
 * @author  Chris Burton <csburton@gmail.com>
 */
class RecentOrders extends AbstractBlock implements BlockInterface
{
    /**
     * {@inheritdoc}
     */
    public function render(array $arguments = [])
    {
        return $this->getApplication()['twig']->render('admin/dashboard/blocks/recent-orders.twig');
    }
}
