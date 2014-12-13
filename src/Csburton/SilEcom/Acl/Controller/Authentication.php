<?php

namespace Csburton\SilEcom\Acl\Controller;

use Csburton\SilEcom\Core\Model\Controller\Admin;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class Authentication extends Admin
{
    public function adminLoginAction(Request $request)
    {
        /**
         * @var $form \Symfony\Component\Form\Form
         */
        $form = $this->getApplication()->getForm('login', $request->request->all())->getForm();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $user = $this->getAuthenticationModel()->authenticateAdminUser($form['username']->getData(), $form['password']->getData());
                if ($user) {
                    $this->getApplication()->getSession()->set('userid', $user->getId());
                    return new RedirectResponse('/admin');
                } else {
                    $form->addError(new FormError($this->getApplication()->getTranslator()->trans('user_not_found')));
                }
            }
        }
        return $this->renderTemplate('admin/login/login.twig', ['form' => $form->createView()]);
    }

    /**
     * @return \Csburton\SilEcom\Acl\Model\Authentication
     * @throws \Csburton\SilEcom\Core\Exception\Service\NotFound
     */
    private function getAuthenticationModel()
    {
        return $this->getApplication()->getService('Authentication');
    }

    public function loginAction(Request $request)
    {
        return $this->renderTemplate('user/login.twig');
    }
}