<?php

namespace Pantono\Acl\Entity\Repository;

use Pantono\Acl\Entity\AdminUser;
use Pantono\Database\Repository\AbstractRepository;

class AclRepository extends AbstractRepository
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
        return $this->_em->getRepository('Pantono\Acl\Entity\AdminUser')->find($userId);
    }

    public function getSingleRole($id)
    {
        return $this->_em->getRepository('Pantono\Acl\Entity\AdminRole')->find($id);
    }


    public function findRoleByName($name)
    {
        return $this->_em->getRepository('Pantono\Acl\Entity\AdminRole')->findOneBy(['name' => $name]);
    }

    /**
     * @param $username
     * @return AdminUser|null
     */
    public function getUserByUsername($username)
    {
        return $this->findOneBy(['username' => $username]);
    }

    public function getRolesWithUserCounts()
    {
        $pdo = $this->_em->getConnection();
        $statement = $pdo->prepare('
          SELECT admin_role.id, admin_role.name, (SELECT COUNT(1) from admin_user_admin_role
          LEFT JOIN admin_user on admin_user_admin_role.admin_user_id=admin_user.id
          where admin_role_id=admin_role.id and active=1) as active_count,
          (SELECT COUNT(1) from admin_user_admin_role
          LEFT JOIN admin_user on admin_user_admin_role.admin_user_id=admin_user.id
          where admin_role_id=admin_role.id and active=0) as inactive_count
          from admin_role
        ');
        $statement->execute();
        return $statement->fetchAll();
    }
}
