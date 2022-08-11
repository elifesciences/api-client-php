<?php

namespace eLife\ApiClient\ApiClient;

use eLife\ApiClient\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;

final class ReviewedPreprintClient
{
    const TYPE_REVIEWED_PREPRINT = 'application/vnd.elife.reviewed-preprint+json';
    const TYPE_REVIEWED_PREPRINT_LIST = 'application/vnd.elife.reviewed-preprint-list+json';

    use ApiClient;

    public function getReviewedPreprint(array $headers, string $id) : PromiseInterface
    {
        return $this->getRequest($this->createUri(['path' => "reviewed-preprint/$id"]), $headers);
    }

    public function listReviewedPreprint(
        array $headers = [],
        int $page = 1,
        int $perPage = 20,
        bool $descendingOrder = true
    ) : PromiseInterface {
        return $this->getRequest(
            $this->createUri([
                'path' => 'reviewed-preprint',
                'query' => [
                    'page' => $page,
                    'per-page' => $perPage,
                    'order' => $descendingOrder ? 'desc' : 'asc',
                ],
            ]),
            $headers
        );
    }
}
