<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\Query\Expr;

class ApplicationRepository extends EntityRepository
{
    public function getApplications() {
        $qb = $this->createQueryBuilder('a');
        $qb->select('a')
            //->andWhere($qb->expr()->orX(
                //$qb->expr()->eq('a.mailRelance', 0),
                //$qb->expr()->isNull('a.mailRelance', null)
            //))
            ->andWhere($qb->expr()->orX(
                $qb->expr()->eq('a.paymentReceiptUploaded', 0),
                $qb->expr()->isNull('a.paymentReceiptUploaded', null),
                $qb->expr()->eq('a.documentsUploaded', 0),
                $qb->expr()->isNull('a.documentsUploaded', null)
            ))
            ->andWhere('a.status != 4 and a.status != -1')
            ->distinct();
        return $qb->getQuery()->execute();
    }
}
