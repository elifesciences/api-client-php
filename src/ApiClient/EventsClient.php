<?php

namespace eLife\ApiSdk\ApiClient;

use eLife\ApiSdk\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;

final class EventsClient
{
    const TYPE_EVENT = 'application/vnd.elife.event+json';
    const TYPE_EVENT_LIST = 'application/vnd.elife.event-list+json';

    use ApiClient;

    public function getEvent(array $headers, string $id) : PromiseInterface
    {
        return $this->getRequest('events/'.$id, $headers);
    }

    public function listEvents(
        array $headers = [],
        int $page = 1,
        int $perPage = 20,
        string $type = 'all',
        bool $descendingOrder = true
    ) : PromiseInterface {
        return $this->getRequest(
            'events?page='.$page.'&per-page='.$perPage.'&type='.$type.'&order='.($descendingOrder ? 'desc' : 'asc'),
            $headers
        );
    }
}
