<?php

namespace eLife\ApiClient\ApiClient;

use DateTimeImmutable;
use eLife\ApiClient\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;

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
        $startsQuery = $starts ? '&start-date='.$starts->format('Y-m-d') : '';
        $endsQuery = $ends ? '&end-date='.$ends->format('Y-m-d') : '';

        return $this->getRequest(
            'covers?page='.$page.'&per-page='.$perPage.'&sort='.$sort.'&order='.($descendingOrder ? 'desc' : 'asc').'&use-date='.$useDate.$startsQuery.$endsQuery,
            $headers
        );
    }

    public function listCurrentCovers(array $headers = []) : PromiseInterface
    {
        return $this->getRequest('covers/current', $headers);
    }
}
