<?php

namespace Pantono\Acl\Controller;

use Pantono\Acl\AdminAuthentication;
use Pantono\Acl\Entity\AdminUser;
use Pantono\Acl\Model\Filter\AdminUserList;
use Pantono\Core\Controller\Controller;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller actions for authentication routes
 *
 * Class Authentication
 *
 * @package Pantono\Acl\Controller
 * @author Chris Burton <csburton@gmail.com>
 */
class Authentication extends Controller
{
    /**
     * Controller action for admin login
     *
     * @param Request $request Request object
     *
     * @return string|Response
     */
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

    /**
     * Controller action for viewing admin users
     *
     * @return string|Response
     */
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

    /**
     * Controller action for adding a new admin user
     *
     * @return string|Response
     */
    public function addAdminUserAction()
    {
        $form = $this->getForm('admin_user');
        $result = $this->handleAdminRequest($form);
        if ($result !== null) {
            return $result;
        }
        return $this->renderTemplate('admin/users/add.twig', ['form' => $form->getForm()->createView()]);
    }

    /**
     * Controller action for editing an admin user
     *
     * @return string|Response
     */
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

    /**
     * Controller action for deleting an admin user
     *
     * @return string|Response
     */
    public function deleteAdminUserAction()
    {
        $id = $this->getRequest()->get('id');
        $user = $this->getAuthenticationModel()->getSingleUser($id);
        if ($this->getRequest()->getMethod() == 'POST') {
            $this->getAuthenticationModel()->deleteAdminUser($id);
        }

        return $this->renderTemplate('admin/users/delete.twig', ['user' => $user]);
    }


    /**
     * Controller action for admin user login
     *
     * @return string|Response
     */
    public function loginAction()
    {
        return $this->renderTemplate('user/login.twig');
    }

    /**
     * Controller action for admin user logout
     *
     * @return RedirectResponse
     */
    public function adminLogoutAction()
    {
        $this->getAuthenticationModel()->logoutUser();
        return new RedirectResponse('/admin/login');
    }

    /**
     * Gets a filtering class to be used for viewing/managing admin users
     *
     * @return AdminUserList
     */
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

    /**
     * Handles the request for adding an admin user
     *
     * @param FormBuilderInterface $formWrapper Admin user form
     *
     * @return null|JsonResponse|RedirectResponse
     */
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

    /**
     * Gets an array of user data given a specific ID
     *
     * @param int $id User ID
     *
     * @return array
     */
    private function getFlatUserData($id)
    {
        $data = $this->getApplication()->getPantonoService('EntityDehydrator')->dehydrateEntity(
            $this->getFormMapping('admin_user'),
            $this->getAuthenticationModel()->getSingleUser($id)
        );
        return $data;
    }

    /**
     * Performs a login check given a specific user and password
     *
     * @param string $username Username to check
     * @param string $password Password to check
     *
     * @return bool|AdminUser
     */
    private function performLoginCheck($username, $password)
    {
        $user = $this->getAuthenticationModel()->authenticateAdminUser($username, $password);
        if (!$user) {
            return false;
        }
        return $user;

    }

    /**
     * Returns instance of the AdminAuthentication class
     *
     * @return AdminAuthentication
     */
    private function getAuthenticationModel()
    {
        return $this->getApplication()->getPantonoService('AdminAuthentication');
    }
}
