<?php namespace Pantono\Acl\Controller;

use Pantono\Core\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class Permissions extends Controller
{
    public function listingAction(Request $request)
    {
        return $this->renderTemplate('admin/permissions/list');
    }

    public function addAction(Request $request)
    {
        return $this->renderTemplate('admin/permissions/add');
    }

    public function editAction(Request $request)
    {
        return $this->renderTemplate('admin/permissions/edit');
    }
}