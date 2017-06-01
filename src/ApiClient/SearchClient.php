<?php

namespace eLife\ApiClient\ApiClient;

use DateTimeImmutable;
use eLife\ApiClient\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Uri;
use function GuzzleHttp\Psr7\build_query;

final class SearchClient
{
    const TYPE_SEARCH = 'application/vnd.elife.search+json';

    use ApiClient;

    public function query(
        array $headers = [],
        string $query = '',
        int $page = 1,
        int $perPage = 20,
        string $sort = 'relevance',
        bool $descendingOrder = true,
        array $subjects = [],
        array $types = [],
        string $useDate = 'default',
        DateTimeImmutable $starts = null,
        DateTimeImmutable $ends = null
    ) : PromiseInterface {
        return $this->getRequest(
            Uri::fromParts([
                'path' => 'search',
                'query' => build_query(['for' => $query] + array_filter([
                    'page' => $page,
                    'per-page' => $perPage,
                    'sort' => $sort,
                    'order' => $descendingOrder ? 'desc' : 'asc',
                    'subject[]' => $subjects,
                    'type[]' => $types,
                    'use-date' => $useDate,
                    'start-date' => $starts ? $starts->format('Y-m-d') : null,
                    'end-date' => $ends ? $ends->format('Y-m-d') : null,
                ])),
            ]),
            $headers
        );
    }
}
