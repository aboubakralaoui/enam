<?php

namespace AppBundle\Repository;
 
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\Query\Expr;

class DiplomaRepository extends EntityRepository
{
    public function getDiplomaTypeByTrainingType($trainingTypeId) {
        $qb = $this->createQueryBuilder('d','tt');
        $qb->select('d')
            ->join('d.trainingType', 'tt')
            ->join('d.diplomaType', 'dt')
            ->andWhere('tt.id = :trainingTypeId')
            ->setParameter('trainingTypeId', $trainingTypeId);
            //->distinct();
        return $qb->getQuery()->getResult();
    }

    public function getDiplomaByDiplomaTypeIdAndBySchoolId($diplomaTypeId,$schoolId) {
        $qb = $this->createQueryBuilder('d');
        $qb->select('d')
            ->join('d.school', 'sf')
            ->join('d.diplomaType', 'dt')
            ->andWhere('dt.id = :diplomaTypeId')
            ->andWhere('sf.id = :schoolId')
            ->setParameter('diplomaTypeId', $diplomaTypeId)
            ->setParameter('schoolId', $schoolId);
        //->distinct();
        return $qb->getQuery()->getResult();
    }

    public function getDiplomaByDiplomaTypeIdAndBySchoolIdAndTrainingTypeId($diplomaTypeId,$schoolId,$schoolFieldId,$trainingTypeId) {
        $qb = $this->createQueryBuilder('d');
        $qb->select('d')
            ->join('d.school', 's')
            ->join('d.diplomaType', 'dt')
            ->join('d.trainingType', 'tt')
            ->join('d.schoolField', 'sf')
            ->andWhere('dt.id = :diplomaTypeId')
            ->andWhere('s.id = :schoolId')
            ->andWhere('tt.id = :trainingTypeId')
            ->andWhere('sf.id = :schoolFieldId')
            ->setParameter('diplomaTypeId', $diplomaTypeId)
            ->setParameter('schoolId', $schoolId)
            ->setParameter('schoolFieldId', $schoolFieldId)
            ->setParameter('trainingTypeId', $trainingTypeId);
        //->distinct();
        return $qb->getQuery()->getOneOrNullResult();
    }
}