<?php

namespace Pantono\Acl\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Pantono\Acl\Entity\AdminUser;

class AclRepository extends EntityRepository
{
    /**
     * @param $userId
     * @return \Pantono\Acl\Entity\AdminRole[]
     */
    public function getRolesForUser($userId)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('r.id, r.name')
            ->from('Pantono\Acl\Entity\AdminUser', 'u')
            ->join('u.role', 'r')
            ->Where('u.id=:id')
            ->setParameter('id', $userId);
        return $qb->getQuery()->getResult();
    }

    /**
     * @return \Pantono\Acl\Entity\AdminRole[]
     */
    public function getRoles()
    {
        return $this->_em->getRepository('Pantono\Acl\Entity\AdminRole')->findAll();
    }

    /**
     * @return \Pantono\Acl\Entity\AdminPrivilege[]
     */
    public function getPrivileges()
    {
        return $this->_em->getRepository('Pantono\Acl\Entity\AdminPrivilege')->findAll();
    }

    /**
     * @param $userId
     * @return AdminUser|null
     */
    public function getUserInfo($userId)
    {
        return $this->find($userId);
    }

    /**
     * @param $username
     * @return AdminUser|null
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
