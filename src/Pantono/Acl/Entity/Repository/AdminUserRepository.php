<?php


namespace Pantono\Acl\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Pantono\Acl\Entity\AdminUser as UserEntity;

class AdminUserRepository extends EntityRepository
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

    public function save($entity)
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }
}