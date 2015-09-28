<?php namespace Pantono\Categories\Entity\Repository;

use Pantono\Categories\Model\Filter\CategoryListFilter;
use Pantono\Database\Repository\AbstractRepository;
use Pantono\Categories\Entity\Category;

/**
 * Repository class for managing categories
 *
 * Class CategoryRepository
 *
 * @package Pantono\Categories\Entity\Repository
 * @author  Chris Burton <csburton@gmail.com>
 */
class CategoryRepository extends AbstractRepository
{
    /**
     * Gets list of categories filtered by state of the filter
     *
     * @param CategoryListFilter $filter Category list filter
     *
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

    /**
     * Find category entity by its Url Key (Slug)
     *
     * @param string $urlKey Slug of category
     *
     * @return Category
     */
    public function getCategoryByUrlKey($urlKey)
    {
        return $this->_em->getRepository('Pantono\Categories\Entity\Category')->findOneBy(['urlKey' => $urlKey]);
    }

    /**
     * Returns a doctrine reference to the provided category id
     *
     * @param int $id Category ID
     *
     * @return Category
     * @throws \Doctrine\ORM\ORMException
     */
    public function getCategoryReference($id)
    {
        return $this->_em->getReference('Pantono\Categories\Entity\Category', $id);
    }

    /**
     * Persists an entity to the database
     *
     * @param \stdClass $entity Entity to save
     */
    public function save($entity)
    {
        $this->_em->persist($entity);
    }
}
