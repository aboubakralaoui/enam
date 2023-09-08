<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\Query\Expr;

class SchoolFieldRepository extends EntityRepository {

    public function getFieldsByDiplomaType($diplomaTypeId,$schoolId) {
        $qb = $this->createQueryBuilder('f');
        $qb->select('f')
            ->innerJoin('f.diplomas', 'd')
            ->leftJoin('d.diplomaType', 'dt')
            ->leftJoin('d.school', 's')
            ->andWhere('dt.id = :diplomaTypeId')
            ->andWhere('s.id = :schoolId')
            ->setParameter('diplomaTypeId', $diplomaTypeId)
            ->setParameter('schoolId', $schoolId);
            //->distinct();
        return $qb->getQuery()->execute();
    }

    public function getFieldsBySchoolId($schoolId) {
        $qb = $this->createQueryBuilder('f');
        $qb->select('f')
            ->innerJoin('f.diplomas', 'd')
            ->leftJoin('d.school', 's')
            ->andWhere('s.id = :schoolId')
            ->setParameter('schoolId', $schoolId)
            ->distinct();
        return $qb->getQuery()->execute();
    }

    public function getFieldsBySchoolIdAndDiplomaTypeId($schoolId,$diplomaTypeId) {
        $qb = $this->createQueryBuilder('f');
        $qb->select('f')
            ->innerJoin('f.diplomas', 'd')
            ->leftJoin('d.diplomaType', 'dt')
            ->leftJoin('d.school', 's')
            ->andWhere('dt.id = :diplomaTypeId')
            ->andWhere('s.id = :schoolId')
            ->setParameter('diplomaTypeId', $diplomaTypeId)
            ->setParameter('schoolId', $schoolId)
            ->distinct();
        return $qb->getQuery()->execute();
    }
}
