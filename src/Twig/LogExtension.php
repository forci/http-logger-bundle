<?php

namespace Forci\Bundle\HttpLogger\Twig;

use Forci\Bundle\HttpLogger\Entity\RequestLog;
use Forci\Bundle\HttpLogger\Entity\RequestLogMessage;
use Twig\Extension\AbstractExtension;

class LogExtension extends AbstractExtension {

    public function getFilters() {
        return [
            new \Twig\TwigFilter('getCurlCommand', [$this, 'getCurlCommand'])
        ];
    }

    public function getCurlCommand(RequestLog $log) {
        /** @var RequestLogMessage $request */
        $request = $log->getRequest();

        if (!$request) {
            return '';
        }

        $method = $log->getMethod();

        $headers = [];
        foreach ($request->getHeaders() as $header => $values) {
            foreach ($values as $value) {
                $headers[] = sprintf('-H "%s: %s"', $header, $value);
            }
        }

        $pieces = [
            sprintf('-X %s', $method),
            implode(' ', $headers)
        ];

        if ($request->getContent()) {
            $pieces[] = sprintf('-d "%s"', str_replace('"', '\"', $request->getContent()));
        }

        $command = sprintf('curl %s %s', $log->getUrl(), implode(' ', $pieces));

        return $command;
    }

}