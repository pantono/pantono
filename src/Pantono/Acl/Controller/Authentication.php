<?php

namespace Pantono\Acl\Controller;

use Pantono\Acl\Model\Filter\AdminUserList;
use Pantono\Core\Controller\Controller;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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

    public function adminUsersAction()
    {
        $filter = $this->getAdminUsersFilter();
        if (!$this->getCurrentUser()->getSuperAdmin()) {
            if ($this->isAllowed('Pantono\Acl\Controller\Authentication', 'onlyManagerCurrentSuppliers')) {
                if (!$this->getCurrentUser()->getSupplier()) {
                    throw new AccessDeniedException('You are not authorised to access this resource');
                }
                $filter->setSupplierId($this->getCurrentUser()->getSupplier()->getId());
            }
        }
        $list = $this->getAuthenticationModel()->getAdminUserList($filter);
        return $this->renderTemplate('admin/users/list.twig', ['list' => $list]);
    }

    private function getAdminUsersFilter()
    {
        $filter = new AdminUserList();
        if ($this->getRequest()->getMethod() === 'POST') {
            $filter->setActive($this->getRequest()->request->get('active', null));
            $filter->setSupplierId($this->getRequest()->request->get('supplier_id', null));
            $filter->setEmail($this->getRequest()->request->get('supplier_id', null));
        }
        return $filter;
    }

    public function addAdminUserAction()
    {
        $form = $this->getForm('admin_user');
        $result = $this->handleAdminRequest($form);
        if ($result !== null) {
            return $result;
        }
        return $this->renderTemplate('admin/users/add.twig', ['form' => $form->getForm()->createView()]);
    }

    private function handleAdminRequest(FormBuilderInterface $formWrapper)
    {
        $form = $formWrapper->getForm();
        if ($this->getRequest()->getMethod() == 'POST') {
            $form->handleRequest($this->getRequest());
            $valid = $form->isValid();
            if ($valid) {
                $data = $form->getData();
                $entity = $this->getApplication()->getPantonoService('EntityHydrator')->hydrateEntity($this->getFormMapping('admin_user'), $data);
                if ($this->getAuthenticationModel()->saveAdminUser($entity)) {
                    $this->flashMessenger($this->translate('User has been updated'), 'success');
                    return new RedirectResponse('/admin/users');
                }
            }
            return new JsonResponse(['success' => $valid, 'message' => 'Please fix form errors', 'errors' => $this->getFormErrors($form)]);
        }
        return null;
    }

    public function editAdminUserAction()
    {
        $form = $this->getForm('admin_user');
        $id = $this->getRequest()->get('id');
        if ($id !== null) {
            $data = $this->getFlatUserData($id);
            $data['image'] = null;
            $form->getForm()->setData($data);
        }
        $result = $this->handleAdminRequest($form);
        if ($result !== null) {
            return $result;
        }
        return $this->renderTemplate('admin/users/add.twig', ['form' => $form->getForm()->createView()]);
    }

    private function getFlatUserData($id)
    {
        $data = $this->getApplication()->getPantonoService('EntityDehydrator')->dehydrateEntity(
            $this->getFormMapping('admin_user'),
            $this->getAuthenticationModel()->getSingleUser($id)
        );
        return $data;
    }

    public function deleteAdminUserAction()
    {
        $id = $this->getRequest()->get('id');
        $user = $this->getAuthenticationModel()->getSingleUser($id);
        if ($this->getRequest()->getMethod() == 'POST') {
            $this->getAuthenticationModel()->deleteAdminUser($id);
        }

        return $this->renderTemplate('admin/users/delete.twig', ['user' => $user]);
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

    public function adminLogoutAction()
    {
        $this->getAuthenticationModel()->logoutUser();
        return new RedirectResponse('/admin/login');
    }
}
