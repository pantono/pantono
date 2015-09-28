<?php namespace Pantono\Acl\Controller;

use Pantono\Acl\Acl;
use Pantono\Acl\Exception\Acl\RoleNotFound;
use Pantono\Core\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Controller actions for managing admin user permissions
 *
 * Class Permissions
 *
 * @package Pantono\Acl\Controller
 *
 * @author Chris Burton <csburton@gmail.com>
 */
class Permissions extends Controller
{
    /**
     * Controller action for an overview of admin permissions
     *
     * @return string|Response
     */
    public function overviewAction()
    {
        $roles = $this->getAclClass()->getRolesWithUserCounts();
        $permissions = $this->getAclClass()->getDefinedPermissions();
        if ($this->getRequest()->getMethod() == 'POST') {
            $permissions = $this->getRequest()->request->get('permissions');
            $this->getAclClass()->updatePrivileges($permissions);
            $this->flashMessenger('Permissions have been updated');
            return new RedirectResponse('/admin/permissions');
        }
        return $this->renderTemplate('admin/permissions/list.twig',
            ['roles' => $roles, 'permissions' => $permissions]
        );
    }

    /**
     * Controller action for checking user permissions
     *
     * @return Response
     */
    public function checkPermissionAction()
    {
        return $this->renderJson(['success' => true]);
    }


    /**
     * Controller action for deleting a role
     *
     * @return string|Response
     */
    public function deleteRoleAction()
    {
        if ($this->getRequest()->getMethod() == 'POST') {
            try {
                $this->getAclClass()->deleteRole($this->getRequest()->get('id'));
                return $this->renderJson(['success' => true]);
            } catch (RoleNotFound $e) {
                return $this->renderJson(['success' => false, 'message' => 'Role does not exist']);
            }
        }
        return $this->renderTemplate('admin/permissions/delete-role.twig');
    }

    /**
     * Controller action to add a new role
     *
     * @return string|Response
     */
    public function addRoleAction()
    {
        $formWrapper = $this->getRoleForm();
        if ($this->getRequest()->getMethod() == 'POST') {
            $form = $formWrapper->getForm();
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                try {
                    $data = $form->getData();
                    $name = $data['name'];
                    $this->getAclClass()->addRole($name);
                    return $this->renderJson(['success' => true]);
                } catch (\Exception $e) {
                    return $this->renderJson(['success' => false, 'message' => $e->getMessage()]);
                }
            }
            return $this->renderJson(['success' => false, 'message' => $form->getErrors()]);
        }

        return $this->renderTemplate('admin/permissions/add-role.twig', ['form' => $formWrapper->getForm()->createView()]);
    }

    /**
     * Gets an instance of the Add Role form
     *
     * @return FormBuilderInterface
     */
    private function getRoleForm()
    {
        return $this->getApplication()->getForm('add_role');
    }

    /**
     * Gets an instance of the Acl Class
     *
     * @return Acl
     */
    private function getAclClass()
    {
        return $this->getApplication()->getPantonoService('Acl');
    }
}
