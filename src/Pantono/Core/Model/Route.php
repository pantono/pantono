<?php namespace Pantono\Core\Model;

class Route
{
    private $path;
    private $controller;
    private $action;
    private $skipAcl = false;
    private $requiresAdminAuth = false;

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param mixed $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
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
     * @return boolean
     */
    public function isRequiresAdminAuth()
    {
        return $this->requiresAdminAuth;
    }

    /**
     * @param boolean $requiresAdminAuth
     */
    public function setRequiresAdminAuth($requiresAdminAuth)
    {
        $this->requiresAdminAuth = $requiresAdminAuth;
    }

    /**
     * @return boolean
     */
    public function isSkipAcl()
    {
        return $this->skipAcl;
    }

    /**
     * @param boolean $skipAcl
     */
    public function setSkipAcl($skipAcl)
    {
        $this->skipAcl = $skipAcl;
    }
}
