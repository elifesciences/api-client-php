<?php

namespace eLife\ApiClient\ApiClient;

use eLife\ApiClient\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;

final class LabsClient
{
    const TYPE_EXPERIMENT = 'application/vnd.elife.labs-experiment+json';
    const TYPE_EXPERIMENT_LIST = 'application/vnd.elife.labs-experiment-list+json';

    use ApiClient;

    public function getExperiment(array $headers, int $number) : PromiseInterface
    {
        return $this->getRequest(
            'labs-experiments/'.$number,
            $headers
        );
    }

    public function listExperiments(
        array $headers = [],
        int $page = 1,
        int $perPage = 20,
        bool $descendingOrder = true
    ) : PromiseInterface {
        return $this->getRequest(
            'labs-experiments?page='.$page.'&per-page='.$perPage.'&order='.($descendingOrder ? 'desc' : 'asc'),
            $headers
        );
    }
}
