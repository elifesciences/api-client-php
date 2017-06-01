<?php

namespace eLife\ApiClient\ApiClient;

use eLife\ApiClient\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Uri;
use function GuzzleHttp\Psr7\build_query;

final class EventsClient
{
    const TYPE_EVENT = 'application/vnd.elife.event+json';
    const TYPE_EVENT_LIST = 'application/vnd.elife.event-list+json';

    use ApiClient;

    public function getEvent(array $headers, string $id) : PromiseInterface
    {
        return $this->getRequest(Uri::fromParts(['path' => "events/$id"]), $headers);
    }

    public function listEvents(
        array $headers = [],
        int $page = 1,
        int $perPage = 20,
        string $type = 'all',
        bool $descendingOrder = true
    ) : PromiseInterface {
        return $this->getRequest(
            Uri::fromParts([
                'path' => 'events',
                'query' => build_query([
                    'page' => $page,
                    'per-page' => $perPage,
                    'type' => $type,
                    'order' => $descendingOrder ? 'desc' : 'asc',
                ]),
            ]),
            $headers
        );
    }
}
