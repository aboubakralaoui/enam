<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\Query\Expr;

class CourseRepository extends EntityRepository
{

  public function getCourseByDiplomaTypeAndShool($diplomaType,$school) {
      $qb = $this->createQueryBuilder('c');
      $qb->select('c')
          ->join('c.diplomas', 'd')
          ->andWhere('d.diplomaType = :diplomaType')
          ->andWhere('d.school = :school')
          ->setParameter('diplomaType', $diplomaType)
          ->setParameter('school', $school);
      return $qb->getQuery()->getResult();
  }

  public function findByCriteria($params) {
      $qb = $this->createQueryBuilder('c');
      $qb->select('c')
          ->leftJoin('c.diplomas', 'd')
          ->leftJoin('d.school', 's')
          ->leftJoin('d.schoolField', 'sf')
          ->leftJoin('d.diplomaType', 'dt')
          ->leftJoin('d.trainingType', 'tt');

      if($params['schoolId'] != "" && $params['schoolId'] != null) {
          $qb->andWhere('s.id = :schoolId');
          $qb->setParameter('schoolId', $params['schoolId']);
      }
      if($params['schoolFieldId'] != "" && $params['schoolFieldId'] != null) {
          $qb->andWhere('sf.id = :schoolFieldId');
          $qb->setParameter('schoolFieldId', $params['schoolFieldId']);
      }
      if($params['diplomaTypeId'] != "" && $params['diplomaTypeId'] != null) {
          $qb->andWhere('dt.id = :diplomaTypeId');
          $qb->setParameter('diplomaTypeId', $params['diplomaTypeId']);
      }
      if($params['trainingTypeId'] != "" && $params['trainingTypeId'] != null) {
          $qb->andWhere('tt.id = :trainingTypeId');
          $qb->setParameter('trainingTypeId', $params['trainingTypeId']);
      }

      return $qb->getQuery()->getResult();
  }

}
