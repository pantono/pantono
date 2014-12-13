<?php


namespace Csburton\SilEcom\Acl\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Csburton\SilEcom\Acl\Entity\AdminUser as UserEntity;

class AdminUser extends EntityRepository
{
    public function getUserInfo($userId)
    {
        return $this->find($userId);
    }

    /**
     * @param $username
     * @return UserEntity
     */
    public function getUserByUsername($username)
    {
        return $this->findOneBy(['username' => $username]);
    }

    public function saveUser(UserEntity $user)
    {
        $this->_em->persist($user);
        $this->_em->flush();
        return $user;
    }
}