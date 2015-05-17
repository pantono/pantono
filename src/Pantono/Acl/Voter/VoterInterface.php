<?php namespace Pantono\Acl\Voter;

interface VoterInterface
{
    public function isAllowed($resource, $action, $arguments);
}