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

use Forci\Bundle\HttpLoggerBundle\Entity\RequestLog;

class RequestLogRepository extends \Doctrine\ORM\EntityRepository {

    public function getQueryBuilder() {
        return $this->createQueryBuilder('l')
            ->addSelect('req, reqType, res, resType, e')
            ->leftJoin('l.request', 'req')
            ->leftJoin('req.type', 'reqType')
            ->leftJoin('l.response', 'res')
            ->leftJoin('res.type', 'resType')
            ->leftJoin('l.exception', 'e');
    }

    public function save(RequestLog $log) {
        $em = $this->getEntityManager();
        $conn = $em->getConnection();
        $conn->beginTransaction();

        try {
            if ($request = $log->getRequest()) {
                $em->persist($request);
            }

            if ($response = $log->getResponse()) {
                $em->persist($response);
            }

            if ($exception = $log->getException()) {
                $em->persist($exception);
            }

            $em->persist($log);
            $em->flush();

            $conn->commit();
        } catch (\Throwable $e) {
            if ($conn->isTransactionActive()) {
                $conn->rollBack();
            }
            throw $e;
        }
    }

    public function remove(RequestLog $log) {
        $em = $this->getEntityManager();
        $conn = $em->getConnection();
        $conn->beginTransaction();

        try {
            if ($request = $log->getRequest()) {
                $em->remove($request);
            }

            if ($response = $log->getResponse()) {
                $em->remove($response);
            }

            if ($exception = $log->getException()) {
                $em->remove($exception);
            }

            $em->remove($log);
            $em->flush();

            $conn->commit();
        } catch (\Throwable $e) {
            if ($conn->isTransactionActive()) {
                $conn->rollBack();
            }
            throw $e;
        }
    }
}
