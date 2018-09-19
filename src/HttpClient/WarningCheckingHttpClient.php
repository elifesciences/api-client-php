<?php

namespace eLife\ApiClient\HttpClient;

use eLife\ApiClient\HttpClient;
use eLife\ApiClient\Result\HttpResult;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;

final class WarningCheckingHttpClient implements HttpClient
{
    private $httpClient;
    private $logger;

    public function __construct(HttpClient $httpClient, LoggerInterface $logger)
    {
        $this->httpClient = $httpClient;
        $this->logger = $logger;
    }

    public function send(RequestInterface $request) : PromiseInterface
    {
        return $this->httpClient->send($request)->then(
            function (HttpResult $result) {
                foreach ($result->getResponse()->getHeader('Warning') as $warning) {
                    $parts = str_getcsv($warning, ' ');
                    if ('299' !== $parts[0] || 'elifesciences.org' !== $parts[1] || empty($parts[2])) {
                        continue;
                    }

                    $this->logger->warning($parts[2], ['result' => $result]);
                }

                return $result;
            }
        );
    }
}
