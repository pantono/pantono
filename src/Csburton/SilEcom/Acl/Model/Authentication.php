<?php

namespace Csburton\SilEcom\Acl\Model;

use Csburton\SilEcom\Acl\Entity\Repository\AdminUser;
use Csburton\SilEcom\Core\Exception\Authentication\UserNotFound;
use Csburton\SilEcom\Acl\Entity\AdminUser as UserEntity;
use Csburton\SilEcom\Contacts\Entity\Contact;

class Authentication
{
    public function __construct(AdminUser $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function authenticateAdminUser($username, $password)
    {
        $user = $this->userRepository->getUserByUsername($username);
        if (!$user) {
            return false;
        }
        $hash = password_hash($password, PASSWORD_DEFAULT);

        if (password_verify($user->getPassword(), $hash)) {
            if (password_needs_rehash($user->getPassword(), PASSWORD_DEFAULT)) {
                $hash = password_hash($user->getPassword(), PASSWORD_DEFAULT);
                $user->setPassword($hash);
            }
            return true;
        }
        return false;
    }

    public function addAdminUser($username, $password, Contact $contact) {
        $user = new UserEntity();
        $user->setUsername($username);
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $user->setPassword($hash);
        $user->setLastLogin(null);
        $user->setContact($contact);
    }
}