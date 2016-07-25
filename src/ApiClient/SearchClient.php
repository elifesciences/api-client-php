<?php

namespace eLife\ApiSdk\ApiClient;

use eLife\ApiSdk\ApiClient;
use eLife\ApiSdk\MediaType;
use GuzzleHttp\Promise\PromiseInterface;

final class SearchClient
{
    use ApiClient;

    public function query(
        int $version,
        string $query = '',
        int $page = 1,
        int $perPage = 20,
        string $sort = 'relevance',
        bool $descendingOrder = true,
        array $subjects = [],
        array $types = []
    ) : PromiseInterface {
        $subjectQuery = '';
        foreach ($subjects as $subject) {
            $subjectQuery .= '&subject[]='.$subject;
        }
        $typeQuery = '';
        foreach ($types as $type) {
            $typeQuery .= '&type[]='.$type;
        }

        return $this->getRequest(
            'search?for='.$query.'&page='.$page.'&per-page='.$perPage.'&sort='.$sort.'&order='.($descendingOrder ? 'desc' : 'asc').$subjectQuery.$typeQuery,
            new MediaType('application/vnd.elife.search+json', $version)
        );
    }
}
