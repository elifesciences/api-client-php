<?php

namespace eLife\ApiClient\ApiClient;

use eLife\ApiClient\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;

final class MetricsClient
{
    const TYPE_METRIC = 'application/vnd.elife.metric+json';

    use ApiClient;

    public function citations(
        array $headers,
        string $type,
        string $id,
        string $by = 'month',
        int $page = 1,
        int $perPage = 20,
        bool $descendingOrder = true
    ) : PromiseInterface {
        return $this->getRequest('metrics/'.$type.'/'.$id.'/citations?by='.$by.'&page='.$page.'&per-page='.$perPage.'&order='.($descendingOrder ? 'desc' : 'asc'),
            $headers);
    }

    public function downloads(
        array $headers,
        string $type,
        string $id,
        string $by = 'month',
        int $page = 1,
        int $perPage = 20,
        bool $descendingOrder = true
    ) : PromiseInterface {
        return $this->getRequest('metrics/'.$type.'/'.$id.'/downloads?by='.$by.'&page='.$page.'&per-page='.$perPage.'&order='.($descendingOrder ? 'desc' : 'asc'),
            $headers);
    }

    public function pageViews(
        array $headers,
        string $type,
        string $id,
        string $by = 'month',
        int $page = 1,
        int $perPage = 20,
        bool $descendingOrder = true
    ) : PromiseInterface {
        return $this->getRequest('metrics/'.$type.'/'.$id.'/page-views?by='.$by.'&page='.$page.'&per-page='.$perPage.'&order='.($descendingOrder ? 'desc' : 'asc'),
            $headers);
    }
}
