<?php

namespace eLife\ApiClient\HttpClient;

use eLife\ApiClient\HttpClient;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class BatchingHttpClientTest extends TestCase
{
    public function testRandomSequenceOfSendAndWaits()
    {
        $originalClient = $this->createMock(HttpClient::class);
        $originalClient
            ->expects($this->any())
            ->method('send')
            ->willReturnCallback(function ($request) {
                $promise = new Promise(function () use (&$promise, $request) {
                    $response = new Response(200, [], $request->getRequestTarget());
                    $promise->resolve($response);
                });

                return $promise;
            });

        $batchSize = mt_rand(1, 100);
        $stepsCount = mt_rand(1, 100);
        $steps = [];
        for ($i = 0; $i < $stepsCount; $i++) {
            $steps[] = ['action' => 'send', 'what' => $i];
            $steps[] = ['action' => 'wait', 'what' => $i];
        }

        $client = new BatchingHttpClient($originalClient, $batchSize);
        $promises = [];
        foreach ($steps as $step) {
            switch ($step['action']) {
                case 'send':
                    $request = new Request('GET', '/' . $step['what']);
                    $promises[$step['what']] = $client->send($request);
                    break;
                case 'wait':
                    $this->assertEquals(
                        '/' . $step['what'],
                        (string) $promises[$step['what']]->wait()->getBody()
                    );
                    break;
                default:
                    $this->fail('Step not supported: ' . var_export($step, true));
            }
        }
    }
}
