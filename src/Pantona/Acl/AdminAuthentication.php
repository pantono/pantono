<?php namespace Pantona\Acl;

use Pantona\Acl\Entity\Repository\AdminUserRepository;

class AdminAuthentication
{
    private $repository;
    public function __construct(AdminUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function authenticateAdminUser($username, $password)
    {
        $user = $this->repository->getUserByUsername($username);
        if (!$user) {
            return false;
        }
        $hash = password_hash($password, PASSWORD_DEFAULT);

        if (password_verify($user->getPassword(), $hash)) {
            if (password_needs_rehash($user->getPassword(), PASSWORD_DEFAULT)) {
                $hash = password_hash($user->getPassword(), PASSWORD_DEFAULT);
                $user->setPassword($hash);
                $this->repository->save($user);
            }
            return $user;
        }
        return false;
    }

    public function addAdminUser()
    {

    }
}