<?php

namespace eLife\ApiClient\ApiClient;

use eLife\ApiClient\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;

final class RegionalCollectionsClient
{
    const TYPE_REGIONAL_COLLECTION = 'application/vnd.elife.regional-collection+json';
    const TYPE_REGIONAL_COLLECTION_LIST = 'application/vnd.elife.regional-collection-list+json';

    use ApiClient;

    public function getCollection(array $headers, string $id) : PromiseInterface
    {
        return $this->getRequest($this->createUri(['path' => "regional-collections/$id"]), $headers);
    }

    public function listRegionalCollections(
        array $headers = [],
        int $page = 1,
        int $perPage = 20,
        bool $descendingOrder = true,
        array $subjects = [],
        array $containing = []
    ) : PromiseInterface {
        return $this->getRequest(
            $this->createUri([
                'path' => 'regional-collections',
                'query' => [
                    'page' => $page,
                    'per-page' => $perPage,
                    'order' => $descendingOrder ? 'desc' : 'asc',
                    'subject[]' => $subjects,
                    'containing[]' => $containing,
                ],
            ]),
            $headers
        );
    }
}
