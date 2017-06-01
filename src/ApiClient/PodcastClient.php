<?php

namespace eLife\ApiClient\ApiClient;

use eLife\ApiClient\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Uri;
use function GuzzleHttp\Psr7\build_query;

final class PodcastClient
{
    const TYPE_PODCAST_EPISODE = 'application/vnd.elife.podcast-episode+json';
    const TYPE_PODCAST_EPISODE_LIST = 'application/vnd.elife.podcast-episode-list+json';

    use ApiClient;

    public function getEpisode(array $headers, int $number) : PromiseInterface
    {
        return $this->getRequest(Uri::fromParts(['path' => "podcast-episodes/$number"]), $headers);
    }

    public function listEpisodes(
        array $headers = [],
        int $page = 1,
        int $perPage = 20,
        bool $descendingOrder = true
    ) : PromiseInterface {
        return $this->getRequest(
            Uri::fromParts([
                'path' => 'podcast-episodes',
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
