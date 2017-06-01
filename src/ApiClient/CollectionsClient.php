<?php

namespace eLife\ApiClient\ApiClient;

use eLife\ApiClient\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Uri;
use function GuzzleHttp\Psr7\build_query;

final class CollectionsClient
{
    const TYPE_COLLECTION = 'application/vnd.elife.collection+json';
    const TYPE_COLLECTION_LIST = 'application/vnd.elife.collection-list+json';

    use ApiClient;

    public function getCollection(array $headers, string $id) : PromiseInterface
    {
        return $this->getRequest(Uri::fromParts(['path' => "collections/$id"]), $headers);
    }

    public function listCollections(
        array $headers = [],
        int $page = 1,
        int $perPage = 20,
        bool $descendingOrder = true,
        array $subjects = []
    ) : PromiseInterface {
        return $this->getRequest(
            Uri::fromParts([
                'path' => 'collections',
                'query' => build_query([
                    'page' => $page,
                    'per-page' => $perPage,
                    'order' => $descendingOrder ? 'desc' : 'asc',
                    'subject[]' => $subjects,
                ]),
            ]),
            $headers
        );
    }
}
