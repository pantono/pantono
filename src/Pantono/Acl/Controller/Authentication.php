<?php

namespace Pantono\Acl\Controller;

use Pantono\Core\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

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
                $user = $this->getAuthenticationModel()->authenticateAdminUser($form['username']->getData(), $form['password']->getData());
                if ($user) {
                    $this->getApplication()->getSession()->set('userid', $user->getId());
                    return new RedirectResponse('/admin');
                }
                if (!$user) {
                    $form->addError(new FormError($this->getApplication()->getTranslator()->trans('user_not_found')));
                }
            }
        }
        return $this->renderTemplate('admin/login/login.twig', ['form' => $form->createView()]);
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