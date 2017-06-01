<?php

namespace eLife\ApiClient\ApiClient;

use eLife\ApiClient\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Uri;
use function GuzzleHttp\Psr7\build_query;

final class PeopleClient
{
    const TYPE_PERSON = 'application/vnd.elife.person+json';
    const TYPE_PERSON_LIST = 'application/vnd.elife.person-list+json';

    use ApiClient;

    public function getPerson(array $headers, string $id) : PromiseInterface
    {
        return $this->getRequest(Uri::fromParts(['path' => "people/$id"]), $headers);
    }

    public function listPeople(
        array $headers = [],
        int $page = 1,
        int $perPage = 20,
        bool $descendingOrder = true,
        array $subjects = [],
        string $type = null
    ) : PromiseInterface {
        return $this->getRequest(
            Uri::fromParts([
                'path' => 'people',
                'query' => build_query(array_filter([
                    'page' => $page,
                    'per-page' => $perPage,
                    'order' => $descendingOrder ? 'desc' : 'asc',
                    'subject[]' => $subjects,
                    'type' => $type,
                ])),
            ]),
            $headers
        );
    }
}
