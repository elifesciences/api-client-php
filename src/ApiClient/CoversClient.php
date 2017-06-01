<?php

namespace eLife\ApiClient\ApiClient;

use DateTimeImmutable;
use eLife\ApiClient\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Uri;
use function GuzzleHttp\Psr7\build_query;

final class CoversClient
{
    const TYPE_COVERS_LIST = 'application/vnd.elife.cover-list+json';

    use ApiClient;

    public function listCovers(
        array $headers = [],
        int $page = 1,
        int $perPage = 20,
        string $sort = 'date',
        bool $descendingOrder = true,
        string $useDate = 'default',
        DateTimeImmutable $starts = null,
        DateTimeImmutable $ends = null
    ) : PromiseInterface {
        return $this->getRequest(
            Uri::fromParts([
                'path' => 'covers',
                'query' => build_query([
                    'page' => $page,
                    'per-page' => $perPage,
                    'sort' => $sort,
                    'order' => $descendingOrder ? 'desc' : 'asc',
                    'use-date' => $useDate,
                    'start-date' => $starts ? $starts->format('Y-m-d') : null,
                    'end-date' => $ends ? $ends->format('Y-m-d') : null,
                ]),
            ]),
            $headers
        );
    }

    public function listCurrentCovers(array $headers = []) : PromiseInterface
    {
        return $this->getRequest(Uri::fromParts(['path' => 'covers/current']), $headers);
    }
}
