<?php

namespace eLife\ApiClient\ApiClient;

use eLife\ApiClient\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;

final class PodcastClient
{
    const TYPE_PODCAST_EPISODE = 'application/vnd.elife.podcast-episode+json';
    const TYPE_PODCAST_EPISODE_LIST = 'application/vnd.elife.podcast-episode-list+json';

    use ApiClient;

    public function getEpisode(array $headers, int $number) : PromiseInterface
    {
        return $this->getRequest('podcast-episodes/'.$number, $headers);
    }

    public function listEpisodes(
        array $headers = [],
        int $page = 1,
        int $perPage = 20,
        bool $descendingOrder = true,
        string $subject = null
    ) : PromiseInterface {
        $subjectQuery = ('' !== trim($subject)) ? '&subject='.$subject : '';

        return $this->getRequest(
            'podcast-episodes?page='.$page.'&per-page='.$perPage.'&order='.($descendingOrder ? 'desc' : 'asc').$subjectQuery,
            $headers
        );
    }
}
