<?php namespace Pantono\Templates\Model\Table;

class Row
{
    private $attributes;
    private $cells;
    private $id;
    private $actions;

    /**
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param mixed $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @return mixed
     */
    public function getCells()
    {
        return $this->cells;
    }

    /**
     * @param mixed $cells
     */
    public function setCells($cells)
    {
        $this->cells = $cells;
    }

    public function addCell(Cell $cell)
    {
        $this->cells[] = $cell;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function hasActions()
    {
        return !empty($this->actions);
    }

    public function addAction(Action $action)
    {
        $this->actions[] = $action;
    }

    /**
     * @return Action[]
     */
    public function getActions()
    {
        return $this->actions;
    }

    public function getActionString()
    {
        $string = '';
        foreach ($this->getActions() as $action) {
            $string .= $action->__toString();
        }
        return $string;
    }
}
