<?php

namespace eLife\ApiClient\ApiClient;

use eLife\ApiClient\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;

final class JobAdvertsClient
{
    const TYPE_POST = 'application/vnd.elife.job-advert+json';
    const TYPE_POST_LIST = 'application/vnd.elife.job-advert-list+json';

    use ApiClient;

    public function getPost(array $headers, string $id) : PromiseInterface
    {
        return $this->getRequest(
            $this->createUri(['path' => "job-adverts/$id"]),
            $headers
        );
    }

    public function listPosts(
        array $headers = [],
        int $page = 1,
        int $perPage = 20,
        string $show = 'all',
        bool $descendingOrder = true
    ) : PromiseInterface {
        return $this->getRequest(
            $this->createUri([
                'path' => 'job-adverts',
                'query' => [
                    'page' => $page,
                    'per-page' => $perPage,
                    'show' => $show,
                    'order' => $descendingOrder ? 'desc' : 'asc',
                ],
            ]),
            $headers
        );
    }
}
