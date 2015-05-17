<?php namespace Pantono\Acl\Voter;

use Pantono\Acl\Entity\AdminUser;

interface VoterInterface
{
    public function isAllowed($resource, $action, $arguments, AdminUser $user);
}
