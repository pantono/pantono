<?php namespace Pantono\Admin\Block;

use Pantono\Core\Block\BlockInterface;
use Pantono\Core\Block\AbstractBlock;

class RecentOrders extends AbstractBlock implements BlockInterface
{
    public function render(array $arguments = [])
    {
        return $this->getApplication()['twig']->render('admin/dashboard/blocks/recent-orders.twig');
    }
}
