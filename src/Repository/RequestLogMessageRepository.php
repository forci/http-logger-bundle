<?php

/*
 * This file is part of the ForciHttpLoggerBundle package.
 *
 * (c) Martin Kirilov <wucdbm@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Forci\Bundle\HttpLoggerBundle\Repository;

use Forci\Bundle\HttpLoggerBundle\Entity\RequestLogMessage;

class RequestLogMessageRepository extends \Doctrine\ORM\EntityRepository {

    /**
     * @param $id
     *
     * @return RequestLogMessage|null
     */
    public function findOneById($id) {
        $builder = $this->createQueryBuilder('m')
            ->addSelect('t')
            ->leftJoin('m.type', 't')
            ->andWhere('m.id = :id')
            ->setParameter('id', $id);

        $query = $builder->getQuery();

        return $query->getOneOrNullResult();
    }
}
