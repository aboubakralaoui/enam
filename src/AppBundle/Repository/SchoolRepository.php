<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\Query\Expr;

class SchoolRepository extends EntityRepository {

    public function getSchoolByDiplomaType($diplomaTypeId) {
        $qb = $this->createQueryBuilder('s');
        $qb->select('s')
        ->innerJoin('s.diplomas', 'd')
        ->leftJoin('d.diplomaType', 'dt')
        ->andWhere('dt.id = :diplomaTypeId')
        ->setParameter('diplomaTypeId', $diplomaTypeId)
        ->distinct();
        return $qb->getQuery()->execute();
    }
}
