<?php

namespace eLife\ApiClient\ApiClient;

use eLife\ApiClient\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;

final class CoversClient
{
    const TYPE_COVERS_LIST = 'application/vnd.elife.collection-list+json';

    use ApiClient;

    public function listCovers(
        array $headers = [],
        int $page = 1,
        int $perPage = 20,
        bool $descendingOrder = true
    ) : PromiseInterface {
        return $this->getRequest(
            'covers?page='.$page.'&per-page='.$perPage.'&order='.($descendingOrder ? 'desc' : 'asc'),
            $headers
        );
    }

    public function listCurrentCovers(array $headers = []) : PromiseInterface
    {
        return $this->getRequest('covers/current', $headers);
    }
}
