<?php namespace Pantono\Acl\Model;

class Voter
{
    private $resource;
    private $action;
    private $arguments;
    private $voterClass;

    /**
     * @return mixed
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param mixed $resource
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param mixed $arguments
     */
    public function setArguments($arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * @return mixed
     */
    public function getVoterClass()
    {
        return $this->voterClass;
    }

    /**
     * @param mixed $voterClass
     */
    public function setVoterClass($voterClass)
    {
        $this->voterClass = $voterClass;
    }
}
