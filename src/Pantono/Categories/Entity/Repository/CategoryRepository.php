<?php namespace Pantono\Categories\Entity\Repository;

use Pantono\Categories\Model\Filter\CategoryListFilter;
use Pantono\Database\Repository\AbstractRepository;

class CategoryRepository extends AbstractRepository
{
    /**
     * @param CategoryListFilter $filter
     * @return \Pantono\Categories\Entity\Category[]
     */
    public function getCategoryList(CategoryListFilter $filter)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('c')
            ->from('Pantono\Categories\Entity\Category', 'c');

        if ($filter->getActive()) {
            $qb->andWhere('c.active = :active')
                ->setParameter('active', $filter->getActive());
        }

        if ($filter->getSearch()) {
            $qb->andWhere('c.name like :search')
                ->setParameter('name', '%' . $filter->getSearch() . '%');
        }

        if ($filter->getParentId()) {
            $qb->andWhere('c.parent = :parent')
                ->setParameter('parent', $this->getCategoryReference($filter->getParentId()));
        }
        $qb->setMaxResults($filter->getPerPage());
        $qb->setFirstResult($filter->getOffset());

        return $qb->getQuery()->getResult();
    }

    public function getCategoryByUrlKey($urlKey)
    {
        return $this->_em->getRepository('Pantono\Categories\Entity\Category')->findOneBy(['urlKey' => $urlKey]);
    }

    public function getCategoryReference($id)
    {
        return $this->_em->getReference('Pantono\Categories\Entity\Category', $id);
    }

    public function save($entity)
    {
        $this->_em->persist($entity);
    }
}
