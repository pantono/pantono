<?php namespace Pantono\Acl\Voter;

use Pantono\Acl\Entity\AdminUser;

/**
 * Interface used for voter classes
 *
 * Interface VoterInterface
 *
 * @package Pantono\Acl\Voter
 * @author Chris Burton <csburton@gmail.com>
 */
interface VoterInterface
{
    public function isAllowed($resource, $action, $arguments, AdminUser $user);
}
