<?php

namespace eLife\ApiClient\ApiClient;

use eLife\ApiClient\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;

final class PressPackagesClient
{
    const TYPE_PRESS_PACKAGE = 'application/vnd.elife.press-package+json';
    const TYPE_PRESS_PACKAGE_LIST = 'application/vnd.elife.press-package-list+json';

    use ApiClient;

    public function getPackage(array $headers, string $id) : PromiseInterface
    {
        return $this->getRequest('press-packages/'.$id, $headers);
    }

    public function listPackages(
        array $headers = [],
        int $page = 1,
        int $perPage = 20,
        bool $descendingOrder = true,
        array $subjects = []
    ) : PromiseInterface {
        $subjectQuery = '';
        foreach ($subjects as $subject) {
            $subjectQuery .= '&subject[]='.$subject;
        }

        return $this->getRequest(
            'press-packages?page='.$page.'&per-page='.$perPage.'&order='.($descendingOrder ? 'desc' : 'asc').$subjectQuery,
            $headers
        );
    }
}
