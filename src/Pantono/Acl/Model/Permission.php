<?php namespace Pantono\Acl\Model;

/**
 * Model used for representing a permission
 *
 * Class Permission
 *
 * @package Pantono\Acl\Model
 * @author Chris Burton <csburton@gmail.com>
 */
class Permission
{
    private $name;
    private $resource;
    private $resourceName;
    private $action;
    private $module;

    /**
     * Gets permission name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets permission name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Sets resource name
     *
     * @return mixed
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Gets resource name
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
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * Gets resource name
     *
     * @return string
     */
    public function getResourceName()
    {
        return $this->resourceName;
    }

    /**
     * Sets resource name
     *
     * @param string $resourceName
     */
    public function setResourceName($resourceName)
    {
        $this->resourceName = $resourceName;
    }

    /**
     * Gets module name
     *
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * Sets module name
     *
     * @param string $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }
}
