<?php

namespace Csburton\SilEcom\Core\Model\Controller;

use Csburton\SilEcom\Core\Container\Application;
use Symfony\Component\HttpFoundation\Request;

class Admin
{
    protected $application;
    protected $request;

    public function handleRequest(Application $app, Request $request)
    {
        $this->application = $app;
        $this->request = $request;

        var_dump($request);
    }

    protected function getApplication()
    {
        return $this->application;
    }

    protected function getRequest()
    {
        return $this->request;
    }
}