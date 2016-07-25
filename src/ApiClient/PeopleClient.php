<?php

namespace eLife\ApiSdk\ApiClient;

use eLife\ApiSdk\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;

final class PeopleClient
{
    const TYPE_PERSON = 'application/vnd.elife.person+json';
    const TYPE_PERSON_LIST = 'application/vnd.elife.person-list+json';

    use ApiClient;

    public function getPerson(array $headers, string $id) : PromiseInterface
    {
        return $this->getRequest('people/'.$id, $headers);
    }

    public function listPeople(
        array $headers = [],
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
            $headers
        );
    }
}
