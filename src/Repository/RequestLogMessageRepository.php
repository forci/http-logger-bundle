<?php

/*
 * This file is part of the ForciHttpLoggerBundle package.
 *
 * Copyright (c) Forci Web Consulting Ltd.
 *
 * Author Martin Kirilov <martin@forci.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Forci\Bundle\HttpLogger\Repository;

use Forci\Bundle\HttpLogger\Entity\RequestLogMessage;

class RequestLogMessageRepository extends \Doctrine\ORM\EntityRepository {

    public function findOneById($id): ?RequestLogMessage {
        $builder = $this->createQueryBuilder('m')
            ->addSelect('t')
            ->leftJoin('m.type', 't')
            ->andWhere('m.id = :id')
            ->setParameter('id', $id);

        $query = $builder->getQuery();

        return $query->getOneOrNullResult();
    }
}
