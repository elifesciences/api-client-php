<?php

namespace eLife\ApiClient\ApiClient;

use eLife\ApiClient\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;

final class CollectionsClient
{
    const TYPE_COLLECTION = 'application/vnd.elife.collection+json';
    const TYPE_COLLECTION_LIST = 'application/vnd.elife.collection-list+json';

    use ApiClient;

    public function getCollection(array $headers, string $id) : PromiseInterface
    {
        return $this->getRequest('collections/'.$id, $headers);
    }

    public function listCollections(
        array $headers = [],
        int $page = 1,
        int $perPage = 20,
        bool $descendingOrder = true,
        string $subject = null
    ) : PromiseInterface {
        $subjectQuery = ('' !== trim($subject)) ? '&subject='.$subject : '';

        return $this->getRequest(
            'collections?page='.$page.'&per-page='.$perPage.'&order='.($descendingOrder ? 'desc' : 'asc').$subjectQuery,
            $headers
        );
    }
}
