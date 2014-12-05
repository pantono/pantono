<?php

namespace Csburton\SilEcom\Acl\Service;

use Csburton\SilEcom\Core\Provider\Service;

class Authentication extends Service
{
    public function getService()
    {
        return new \Csburton\SilEcom\Core\Model\Authentication();
    }
}