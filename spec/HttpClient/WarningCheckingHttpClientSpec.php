<?php

namespace spec\eLife\ApiClient\HttpClient;

use eLife\ApiClient\HttpClient;
use eLife\ApiClient\Result\HttpResult;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Log\LoggerInterface;

final class WarningCheckingHttpClientSpec extends ObjectBehavior
{
    private $httpClient;
    private $logger;

    public function let(HttpClient $httpClient, LoggerInterface $logger)
    {
        $this->httpClient = $httpClient;
        $this->logger = $logger;

        $this->beConstructedWith($this->httpClient, $this->logger);
    }

    public function it_is_a_http_client()
    {
        $this->shouldHaveType(HttpClient::class);
    }

    public function it_logs_elife_warning_headers_on_requests()
    {
        $request = new Request('GET', 'foo');
        $response = new Response(200, [
            'Content-Type' => 'application/vnd.elife.labs-experiment+json; version=1',
            'Warning' => ['299 elifesciences.org "This is a warning"'],
        ],
            json_encode(['foo' => ['bar', 'baz']]));
        $result = HttpResult::fromResponse($response);
        $promise = new FulfilledPromise($result);

        $this->httpClient->send($request)->willReturn($promise);

        $this->send($request)->getWrappedObject()->wait();

        $this->logger->warning('This is a warning', ['result' => $result])->shouldHaveBeenCalled();
    }

    public function it_does_not_log_other_warning_headers_on_requests()
    {
        $request = new Request('GET', 'foo');
        $response = new Response(200, [
            'Content-Type' => 'application/vnd.elife.labs-experiment+json; version=1',
            'Warning' => ['299 someone "This is a different warning"'],
        ],
            json_encode(['foo' => ['bar', 'baz']]));
        $result = HttpResult::fromResponse($response);
        $promise = new FulfilledPromise($result);

        $this->httpClient->send($request)->willReturn($promise);

        $this->send($request)->getWrappedObject()->wait();

        $this->logger->warning(Argument::any(), Argument::any())->shouldNotHaveBeenCalled();
    }
}
