<?php

namespace eLife\ApiClient\Log;

use eLife\ApiClient\Exception\BadResponse;
use eLife\ApiClient\Exception\HttpProblem;
use GuzzleHttp\Psr7;
use Psr\Http\Message\MessageInterface;

final class HttpMessageProcessor
{
    public function __invoke(array $record)
    {
        if (array_key_exists('exception', $record['context'])) {
            $exception = $record['context']['exception'];
            if ($exception instanceof HttpProblem) {
                $record['extra']['request'] = $this->dumpHttpMessage($exception->getRequest());
            }
            if ($exception instanceof BadResponse) {
                $record['extra']['response'] = $this->dumpHttpMessage($exception->getResponse());
            }
        }

        return $record;
    }

    private function dumpHttpMessage(MessageInterface $message)
    {
        return str_replace("\r", '', Psr7\str($message));
    }
}
