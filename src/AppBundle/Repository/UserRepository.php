<?php

namespace AppBundle\Repository;

use AppBundle\Form\TrainingType;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\Query\Expr;

class UserRepository extends EntityRepository {

    public function findAllPublished($params)
    {
        $qb = $this->createQueryBuilder('u');
        $qb->select('u')
            ->leftJoin('u.applications', 'app')
            ->leftJoin('app.applicationDiplomas', 'ad')
            ->leftJoin('app.course', 'c')
            ->leftJoin('app.school', 's')
            ->leftJoin('ad.diploma', 'd')
            ->leftJoin('d.schoolField', 'sf')
            ->leftJoin('app.diplomaType', 'dt')
            ->leftJoin('app.trainingType', 'tt')
            ->leftJoin( 'u.trainings', 't');

        if($params['search'] != "" && $params['search'] != NULL)
        {
            $searchLike =   $params['search'];
            $qb->andWhere($qb->expr()->orX(
                $qb->expr()->like($qb->expr()->concat('u.lastName', $qb->expr()->concat($qb->expr()->literal(' '), 'u.firstName')), $qb->expr()->literal("%$searchLike%")),
                $qb->expr()->like($qb->expr()->concat('u.firstName', $qb->expr()->concat($qb->expr()->literal(' '), 'u.lastName')), $qb->expr()->literal("%$searchLike%")),
                $qb->expr()->like('u.cin', $qb->expr()->literal("%$searchLike%")),
                $qb->expr()->like('u.cne', $qb->expr()->literal("%$searchLike%")),
                $qb->expr()->like('u.email', $qb->expr()->literal("%$searchLike%")),
                $qb->expr()->like('u.phoneNumber', $qb->expr()->literal("%$searchLike%"))
            ));

            //$qb->setParameter('searchLike', $params['searchLike']);
        }

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
        if($params['passerelleId'] != "" && $params['passerelleId'] != null) {
            $qb->andWhere('c.id = :passerelleId');
            $qb->setParameter('passerelleId', $params['passerelleId']);
        }
        if($params['status'] != "" && $params['status'] != null) {
            if($params['status'] == 0){
                $qb->andWhere($qb->expr()->eq('SIZE(u.applications)', 0));
            }
            if($params['status'] == 1){
                $qb->andWhere('
                    (app.documentsUploaded = 1 or  app.documentsUploaded = 0 or app.documentsUploaded is null)
                    and (app.paymentReceiptUploaded is null or app.paymentReceiptUploaded = 0)
                    and (app.status is null or (app.status !=4 and app.status!=-1))
                ');
                $qb->andWhere($qb->expr()->gt('SIZE(u.applications)', 0));
            }
            if($params['status'] == 2){
                $qb->leftJoin('app.documents', 'dd');
                $qb->andWhere('dd.documentType = 8');
                $qb->andWhere('app.paymentReceiptUploaded = 1 and (app.status is null or (app.status != 4 and app.status != -1))');
            }
            if($params['status'] == 3){
                $qb->andWhere('app.status = :status');
                $qb->setParameter('status', 4);
            }
            if($params['status'] == 4){
                $qb->andWhere('app.status = :status');
                $qb->setParameter('status', -1);
            }
        }
        if($params['level'] != "" && $params['level'] != null) {
            if($params['level'] == 'master'){
                $levels = TrainingType::OPTIONAL_LEVELS;
            }else{
                $levels = TrainingType::MANDATORY_LEVELS;
            }
            $qb->andWhere('t.level IN (:levels)');
            $qb->setParameter('levels', array_values($levels), \Doctrine\DBAL\Connection::PARAM_STR_ARRAY);
        }
        $qb->andWhere('u.role = :role');
        $qb->setParameter('role', "student")
            ->addOrderBy('u.createdAt', 'DESC')
            ->distinct();

        return $qb->getQuery()->getResult();
    }

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

    public function getUseruploadDocuments() {
        $qb = $this->createQueryBuilder('us');
        $qb->select('us')
            ->leftJoin('us.applications', 'appp');
        $qb->andWhere($qb->expr()->orX(
            $qb->expr()->isNotNull('appp.documentsUploaded'),
            $qb->expr()->isNotNull('appp.paymentReceiptUploaded')
        ));
        $qb->andWhere('us.role = :role');
        $qb->setParameter('role', "student")
            ->distinct();
        return $qb->getDQL();
    }

    public function getListOfCandidats($shoolId) {
        $qb = $this->createQueryBuilder('us');
        $qb->select('us');
        if($shoolId != "" && $shoolId != null) {
            $qb->leftJoin('us.applications', 'app');
            $qb->leftJoin('app.course', 'c');
            $qb->leftJoin('c.diploma', 'd');
            $qb->leftJoin('d.school', 's');
            $qb->leftJoin('d.schoolField', 'sf');
            $qb->leftJoin('d.diplomaType', 'dt');
            $qb->leftJoin('d.trainingType', 'tt');
            $qb->andWhere('s.id = :schoolId');
            $qb->setParameter('schoolId', $shoolId);
        }
        $qb->andWhere('us.role = :role');
        $qb->setParameter('role', "student");
        $qb->addOrderBy('us.createdAt', 'DESC');
        $qb->distinct();
        return $qb->getQuery()->execute();
    }
}
