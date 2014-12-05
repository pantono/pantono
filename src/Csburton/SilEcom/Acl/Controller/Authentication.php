<?php

namespace Csburton\SilEcom\Acl\Controller;

use Csburton\SilEcom\Core\Model\Controller\Admin;
use Symfony\Component\HttpFoundation\Request;

class Authentication extends Admin
{
    public function adminLoginAction(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            $username = $request->request->get('username');
            $password = $request->request->get('password');
        }
        return $this->renderTemplate('admin/login/login.twig');
    }

    public function loginAction(Request $request)
    {
        return $this->renderTemplate('user/login.twig');
    }
}