<?php

namespace eLife\ApiSdk\ApiClient;

use eLife\ApiSdk\ApiClient;
use eLife\ApiSdk\MediaType;
use GuzzleHttp\Promise\PromiseInterface;

final class LabsClient
{
    use ApiClient;

    public function getExperiment(int $version, int $number) : PromiseInterface
    {
        return $this->getRequest(
            'labs-experiments/'.$number,
            new MediaType('application/vnd.elife.labs-experiment+json', $version)
        );
    }

    public function listExperiments(
        int $version,
        int $page = 1,
        int $perPage = 20,
        bool $descendingOrder = true
    ) : PromiseInterface {
        return $this->getRequest(
            'labs-experiments?page='.$page.'&per-page='.$perPage.'&order='.($descendingOrder ? 'desc' : 'asc'),
            new MediaType('application/vnd.elife.labs-experiment-list+json', $version)
        );
    }
}
