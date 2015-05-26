<?php namespace Pantono\Core\Event\Events;


class AdminUser extends General
{
    private $user;
    const PRE_SAVE = 'pantono.adminuser.pre-save';
    const POST_SAVE = 'pantono.adminuser.post-save';
    const PRE_DELETE = 'pantono.adminuser.pre-delete';
    const POST_DELETE = 'pantono.adminuser.post-delete';

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}
