<?php

namespace eLife\ApiSdk\ApiClient;

use eLife\ApiSdk\ApiClient;
use eLife\ApiSdk\MediaType;
use GuzzleHttp\Promise\PromiseInterface;

final class PodcastClient
{
    use ApiClient;

    public function getEpisode(int $version, int $number) : PromiseInterface
    {
        return $this->getRequest(
            'podcast-episodes/'.$number,
            new MediaType('application/vnd.elife.podcast-episode+json', $version)
        );
    }

    public function listEpisodes(
        int $version,
        int $page = 1,
        int $perPage = 20,
        bool $descendingOrder = true,
        string $subject = null
    ) : PromiseInterface {
        $subjectQuery = ('' !== trim($subject)) ? '&subject='.$subject : '';

        return $this->getRequest(
            'podcast-episodes?page='.$page.'&per-page='.$perPage.'&order='.($descendingOrder ? 'desc' : 'asc').$subjectQuery,
            new MediaType('application/vnd.elife.podcast-episode-list+json', $version)
        );
    }
}
