<?php

namespace eLife\ApiSdk\ApiClient;

use eLife\ApiSdk\ApiClient;
use eLife\ApiSdk\MediaType;
use GuzzleHttp\Promise\PromiseInterface;

final class PeopleClient
{
    use ApiClient;

    public function getPerson(int $version, string $id) : PromiseInterface
    {
        return $this->getRequest(
            'people/'.$id,
            new MediaType('application/vnd.elife.person+json', $version)
        );
    }

    public function listPeople(
        int $version,
        int $page = 1,
        int $perPage = 20,
        bool $descendingOrder = true,
        string $subject = null,
        string $type = null
    ) : PromiseInterface {
        $subjectQuery = ('' !== trim($subject)) ? '&subject='.$subject : '';
        $typeQuery = ('' !== trim($type)) ? '&type='.$type : '';

        return $this->getRequest(
            'people?page='.$page.'&per-page='.$perPage.'&order='.($descendingOrder ? 'desc' : 'asc').$subjectQuery.$typeQuery,
            new MediaType('application/vnd.elife.person-list+json', $version)
        );
    }
}
