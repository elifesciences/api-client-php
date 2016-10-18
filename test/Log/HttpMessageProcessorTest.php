<?php

namespace eLife\ApiClient\Log;

use eLife\ApiClient\Exception\BadResponse;
use eLife\ApiClient\Exception\NetworkProblem;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit_Framework_TestCase;

class HttpMessageProcessorTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->processor = new HttpMessageProcessor();
    }

    /**
     * @test
     */
    public function it_dumps_requests()
    {
        $decoratedRecord = $this->processor->__invoke([
            'context' => [
                'exception' => new NetworkProblem(
                    'timeout',
                    new Request('GET', '/', ['Host' => 'example.com'])
                ),
            ],
        ]);
        $requestDump = <<<'EOT'
GET / HTTP/1.1
Host: example.com


EOT;
        $this->assertEquals($requestDump, $decoratedRecord['extra']['request']);
    }

    /**
     * @test
     */
    public function it_dumps_responses()
    {
        $decoratedRecord = $this->processor->__invoke([
            'context' => [
                'exception' => new BadResponse(
                    'timeout',
                    new Request('GET', '/', ['Host' => 'example.com']),
                    new Response(200)
                ),
            ],
        ]);
        $responseDump = <<<'EOT'
HTTP/1.1 200 OK


EOT;
        $this->assertEquals($responseDump, $decoratedRecord['extra']['response']);
    }
}
