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

namespace Forci\Bundle\HttpLoggerBundle\Controller;

use Camspiers\JsonPretty\JsonPretty;
use PrettyXml\Formatter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Forci\Bundle\HttpLoggerBundle\Entity\RequestLogMessageType;
use Forci\Bundle\HttpLoggerBundle\Repository\RequestLogMessageRepository;

class MessageController extends Controller {

    public function viewAction($id, $class) {
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        /** @var RequestLogMessageRepository $repository */
        $repository = $em->getRepository($class);
        $message = $repository->findOneById($id);
        if (RequestLogMessageType::ID_XML == $message->getType()->getId()) {
            $formatter = new Formatter();
            $content = $formatter->format($message->getContent());
            $response = new Response($content);
            $response->headers->set('Content-type', 'text/plain');

            return $response;
        }

        if (RequestLogMessageType::ID_JSON == $message->getType()->getId()) {
            $jsonPretty = new JsonPretty();
            $content = $jsonPretty->prettify($message->getContent());
            $response = new Response($content);
            $response->headers->set('Content-type', 'text/plain');

            return $response;
        }

        if (RequestLogMessageType::ID_TEXT_PLAIN == $message->getType()->getId()) {
            $response = new Response($message->getContent());
            $response->headers->set('Content-type', 'text/plain');

            return $response;
        }

        if (RequestLogMessageType::ID_HTML == $message->getType()->getId()) {
            $response = new Response($message->getContent());
            $response->headers->set('Content-type', 'text/html');

            return $response;
        }

        if (RequestLogMessageType::ID_URL_ENCODED == $message->getType()->getId()) {
            $contents = $message->getContent();

            $array = explode('&', $contents);

            $rows = [];
            foreach ($array as $v) {
                list($key, $value) = explode('=', $v);
                $rows[] = implode(' => ', [$key, $value]);
            }

            $response = new Response(implode("\n", $rows));
            $response->headers->set('Content-type', 'text/plain');

            return $response;
        }

        return new Response('UNSUPPORTED TYPE');
    }

    public function viewRawAction($id, $class) {
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        /** @var RequestLogMessageRepository $repository */
        $repository = $em->getRepository($class);
        $message = $repository->findOneById($id);

        return new Response($message->getContent());
    }
}
