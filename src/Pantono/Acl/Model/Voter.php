<?php namespace Pantono\Acl\Model;

/**
 * Model to represent an ACL voter
 *
 * Class Voter
 *
 * @package Pantono\Acl\Model
 * @author Chris Burton <csburton@gmail.com>
 */
class Voter
{
    private $resource;
    private $action;
    private $arguments;
    private $voterClass;

    /**
     * Gets resource name
     *
     * @return string
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Sets resource name
     *
     * @param string $resource
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    /**
     * Gets action name
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Sets action name
     *
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * Gets voter arguments
     *
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Sets voter arguments
     *
     * @param array $arguments
     */
    public function setArguments($arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * Gets voter class name
     *
     * @return string
     */
    public function getVoterClass()
    {
        return $this->voterClass;
    }

    /**
     * Sets voter class name
     *
     * @param string $voterClass
     */
    public function setVoterClass($voterClass)
    {
        $this->voterClass = $voterClass;
    }
}
