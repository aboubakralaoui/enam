<?php

namespace AppBundle\Repository;
 
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\Query\Expr;

class DiplomaTypeRepository extends EntityRepository
{
    public function getDiplomaTypeBySchoolId($schoolId) {
        $qb = $this->createQueryBuilder('dt');
        $qb->select('dt')
            ->innerJoin('dt.diplomas', 'd')
            ->leftJoin('d.school', 's')
            ->andWhere('s.id = :schoolId')
            ->setParameter('schoolId', $schoolId)
            ->distinct();
        return $qb->getQuery()->execute();
    }
}