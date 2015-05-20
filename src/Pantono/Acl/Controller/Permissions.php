<?php namespace Pantono\Acl\Controller;

use Pantono\Acl\Exception\Acl\RoleNotFound;
use Pantono\Core\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class Permissions extends Controller
{
    public function overviewAction(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            var_dump($request->request->all());exit;
        }
        $roles = $this->getAclClass()->getRolesWithUserCounts();
        $permissions = $this->getAclClass()->getDefinedPermissions();
        return $this->renderTemplate('admin/permissions/list.twig',
            ['roles' => $roles, 'permissions' => $permissions]
        );
    }

    public function addAction(Request $request)
    {
        return $this->renderTemplate('admin/permissions/add');
    }

    public function editAction(Request $request)
    {
        return $this->renderTemplate('admin/permissions/edit');
    }

    public function checkPermissionAction(Request $reqest)
    {
        return $this->renderJson(['success' => true]);
    }


    public function deleteRoleAction(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            try {
                $this->getAclClass()->deleteRole($request->get('id'));
                return $this->renderJson(['success' => true]);
            } catch (RoleNotFound $e) {
                return $this->renderJson(['success' => false, 'message' => 'Role does not exist']);
            }

        }
        return $this->renderTemplate('admin/permissions/delete-role.twig');
    }

    public function addRoleAction(Request $request)
    {
        $formWrapper = $this->getRoleForm();
        if ($request->getMethod() == 'POST') {
            $form = $formWrapper->getForm();
            $form->handleRequest($request);
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

    /**
     * @return \Pantono\Acl\PrivilegeRegistry
     */
    private function getPrivilegeRegistry()
    {
        return $this->getApplication()->getPantonoService('PrivilegeRegistry');
    }
}
