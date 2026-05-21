<?php

namespace eLife\ApiClient\HttpClient;

use eLife\ApiClient\HttpClient;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Traversable;

final class UserAgentPrependingHttpClientTest extends TestCase
{
    private $originalClient;
    private $requests;

    #[Before]
    protected function setUpOriginalClient()
    {
        $this->requests = [];

        $this->originalClient = new NotifyingHttpClient($this->createMock(HttpClient::class));

        $this->originalClient->addRequestListener(function (RequestInterface $request) {
            $this->requests[] = $request;
        });
    }

    #[Test]
    #[DataProvider('userAgentProvider')]
    public function it_sets_a_user_agent(string $existing = null, string $input, string $expected)
    {
        $request = new Request('GET', 'foo', ['User-Agent' => $existing]);

        $client = new UserAgentPrependingHttpClient($this->originalClient, $input);

        $client->send($request)->wait();

        $this->assertSame($expected, $this->requests[0]->getHeaderLine('User-Agent'));
    }

    public static function userAgentProvider() : Traversable
    {
        yield 'sets when empty' => [null, 'foo', 'foo'];
        yield 'prepends to existing' => ['bar', 'foo', 'foo bar'];
    }
}
