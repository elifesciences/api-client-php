<?php

namespace eLife\ApiClient\HttpClient;

use eLife\ApiClient\HttpClient;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class BatchingHttpClientTest extends TestCase
{
    public function testRandomSequenceOfSendAndWaitsDataProvider()
    {
        $data = [];
        $batchSize = mt_rand(1, 100);

        for ($requests = 1; $requests <= 10; $requests++) {
            $steps = [];
            for ($i = 0; $i < $requests; $i++) {
                $steps[] = ['action' => 'send', 'what' => $i];
                $steps[] = ['action' => 'wait', 'what' => $i];
            }
            $waitsForwardMovements = array_fill(0, $requests, 0);

            $data[] = [$batchSize, $steps, $waitsForwardMovements];
        }

        return $data;
    }

    /**
     * @dataProvider testRandomSequenceOfSendAndWaitsDataProvider
     */
    public function testRandomSequenceOfSendAndWaits(
        int $batchSize,
        array $steps,
        array $waitsForwardMovements
    ) {
        $originalClient = $this->createMock(HttpClient::class);
        $originalClient
            ->expects($this->any())
            ->method('send')
            ->willReturnCallback(function (RequestInterface $request) {
                return new FulfilledPromise(new Response(200, [], $request->getRequestTarget()));
            });

        $client = new BatchingHttpClient($originalClient, $batchSize);
        $steps = $this->alterStepsByDelayingWaits($steps, $waitsForwardMovements);

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
                        (string)$promises[$step['what']]->wait()->getBody()
                    );
                    break;
                default:
                    $this->fail('Step not supported: ' . var_export($step, true));
            }
        }
    }

    private function alterStepsByDelayingWaits(array $steps, array $waitsForwardMovements): array
    {
        foreach ($waitsForwardMovements as $what => $delta) {
            $currentIndex = array_search($step = ['action' => 'wait', 'what' => $what], $steps);
            $this->assertNotFalse($currentIndex, 'Cannot find step: ' . var_export($step, true));
            $newIndex = min(count($steps), $currentIndex + $delta);
            array_splice($steps, $newIndex, 0, [$steps[$currentIndex]]);
            array_splice($steps, $currentIndex, 1);
        }

        return $steps;
    }
}
