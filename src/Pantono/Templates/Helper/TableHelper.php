<?php namespace Pantono\Templates\Helper;

use Pantono\Core\Event\Dispatcher;
use \Pantono\Templates\Model\Table\Table;
use \Pantono\Core\Event\Events\Table as TableEvent;

class TableHelper
{
    private $dispatcher;
    private $renderer;

    public function __construct(Dispatcher $dispatcher, \Twig_Environment $renderer)
    {
        $this->dispatcher = $dispatcher;
        $this->renderer = $renderer;
    }

    public function renderTable(Table $table)
    {
        $this->dispatcher->dispatchTableEvent(TableEvent::PRE_RENDER, $table);
        $renderedContent = $this->renderer->render('admin/table/table.twig', ['table' => $table]);
        $table->setRenderedContent($renderedContent);
        $this->dispatcher->dispatchFormEvent(TableEvent::POST_RENDER, $table);
        $renderedContent = $table->getRenderedContent();
        return $renderedContent;
    }
}
