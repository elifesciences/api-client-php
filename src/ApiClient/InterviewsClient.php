<?php

namespace eLife\ApiClient\ApiClient;

use eLife\ApiClient\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Uri;
use function GuzzleHttp\Psr7\build_query;

final class InterviewsClient
{
    const TYPE_INTERVIEW = 'application/vnd.elife.interview+json';
    const TYPE_INTERVIEW_LIST = 'application/vnd.elife.interview-list+json';

    use ApiClient;

    public function getInterview(array $headers, string $id) : PromiseInterface
    {
        return $this->getRequest(Uri::fromParts(['path' => "interviews/$id"]), $headers);
    }

    public function listInterviews(
        array $headers = [],
        int $page = 1,
        int $perPage = 20,
        bool $descendingOrder = true
    ) : PromiseInterface {
        return $this->getRequest(
            Uri::fromParts([
                'path' => 'interviews',
                'query' => build_query(array_filter([
                    'page' => $page,
                    'per-page' => $perPage,
                    'order' => $descendingOrder ? 'desc' : 'asc',
                ])),
            ]),
            $headers
        );
    }
}
