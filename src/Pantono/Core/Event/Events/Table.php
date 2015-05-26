<?php namespace Pantono\Core\Event\Events;


class Table extends General
{
    private $table;
    const PRE_RENDER = 'pantono.table.pre-render';
    const POST_RENDER = 'pantono.table.post-render';

    /**
     * @return \Pantono\Templates\Model\Table
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param mixed $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }
}
