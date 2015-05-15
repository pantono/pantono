<?php

namespace Pantono\Acl\Controller;

use Pantono\Core\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class Authentication extends Controller
{
    public function adminLoginAction(Request $request)
    {
        /**
         * @var $form \Symfony\Component\Form\Form
         */
        $form = $this->getApplication()->getForm('login')->getForm();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $user = $this->performLoginCheck($form['username']->getData(), $form['password']->getData());
                if ($user) {
                    $this->getApplication()->getSession()->set('userid', $user->getId());
                    return new RedirectResponse('/admin');
                }
                $form->addError(new FormError($this->getApplication()->getTranslator()->trans('user_not_found')));
            }
        }
        return $this->renderTemplate('admin/login/login.twig', ['form' => $form->createView()]);
    }

    private function performLoginCheck($username, $password)
    {
        $user = $this->getAuthenticationModel()->authenticateAdminUser($username, $password);
        if (!$user) {
            return false;
        }
        return $user;

    }

    /**
     * @return \Pantono\Acl\AdminAuthentication
     */
    private function getAuthenticationModel()
    {
        return $this->getApplication()->getPantonoService('AdminAuthentication');
    }

    public function loginAction()
    {
        return $this->renderTemplate('user/login.twig');
    }
}