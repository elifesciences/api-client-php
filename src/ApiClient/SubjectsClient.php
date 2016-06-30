<?php

namespace eLife\ApiSdk\ApiClient;

use eLife\ApiSdk\ApiClient;
use eLife\ApiSdk\MediaType;
use GuzzleHttp\Promise\PromiseInterface;

final class SubjectsClient
{
    use ApiClient;

    public function getSubject(int $version, string $id) : PromiseInterface
    {
        return $this->getRequest(
            'subjects/'.$id,
            new MediaType('application/vnd.elife.subject+json', $version)
        );
    }

    public function listSubjects(int $version, int $page = 1, int $perPage = 20) : PromiseInterface
    {
        return $this->getRequest(
            'subjects?page='.$page.'&per-page='.$perPage,
            new MediaType('application/vnd.elife.subject-list+json', $version)
        );
    }
}
