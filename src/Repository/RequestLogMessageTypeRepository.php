<?php

namespace Forci\Bundle\HttpLoggerBundle\Repository;

use Forci\Bundle\HttpLoggerBundle\Entity\RequestLogMessageType;

class RequestLogMessageTypeRepository extends \Doctrine\ORM\EntityRepository {

    /**
     * @param $id
     * @return RequestLogMessageType
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneById(int $id) {
        $builder = $this->createQueryBuilder('t')
            ->andWhere('t.id = :id')
            ->setParameter('id', $id);

        $query = $builder->getQuery();

        return $query->getOneOrNullResult();
    }

    public function save(RequestLogMessageType $type) {
        $em = $this->getEntityManager();
        $em->persist($type);
        $em->flush($type);
    }

}