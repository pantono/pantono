<?php namespace Pantono\Acl\Controller;

use Pantono\Acl\Exception\Acl\RoleNotFound;
use Pantono\Core\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Permissions extends Controller
{
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

    public function checkPermissionAction()
    {
        return $this->renderJson(['success' => true]);
    }


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
     * @return \Symfony\Component\Form\FormBuilderInterface
     */
    private function getRoleForm()
    {
        return $this->getApplication()->getForm('add_role');
    }

    /**
     * @return \Pantono\Acl\Acl
     */
    private function getAclClass()
    {
        return $this->getApplication()->getPantonoService('Acl');
    }
}
