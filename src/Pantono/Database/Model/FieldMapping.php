<?php namespace Pantono\Database\Model;

class FieldMapping
{
    private $name;
    private $source_field;
    private $target_field;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSourceField()
    {
        return $this->source_field;
    }

    /**
     * @param mixed $source_field
     */
    public function setSourceField($source_field)
    {
        $this->source_field = $source_field;
    }

    /**
     * @return mixed
     */
    public function getTargetField()
    {
        return $this->target_field;
    }

    /**
     * @param mixed $target_field
     */
    public function setTargetField($target_field)
    {
        $this->target_field = $target_field;
    }
}
