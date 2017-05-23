<?php

namespace eLife\ApiClient\ApiClient;

use eLife\ApiClient\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;

final class LabsClient
{
    const TYPE_POST = 'application/vnd.elife.labs-post+json';
    const TYPE_POST_LIST = 'application/vnd.elife.labs-post-list+json';

    use ApiClient;

    public function getPost(array $headers, int $number) : PromiseInterface
    {
        return $this->getRequest(
            'labs-posts/'.$number,
            $headers
        );
    }

    public function listPosts(
        array $headers = [],
        int $page = 1,
        int $perPage = 20,
        bool $descendingOrder = true
    ) : PromiseInterface {
        return $this->getRequest(
            'labs-posts?page='.$page.'&per-page='.$perPage.'&order='.($descendingOrder ? 'desc' : 'asc'),
            $headers
        );
    }
}
