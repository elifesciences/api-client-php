<?php

namespace eLife\ApiClient\ApiClient;

use eLife\ApiClient\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Uri;
use function GuzzleHttp\Psr7\build_query;

final class PressPackagesClient
{
    const TYPE_PRESS_PACKAGE = 'application/vnd.elife.press-package+json';
    const TYPE_PRESS_PACKAGE_LIST = 'application/vnd.elife.press-package-list+json';

    use ApiClient;

    public function getPackage(array $headers, string $id) : PromiseInterface
    {
        return $this->getRequest(Uri::fromParts(['path' => "press-packages/$id"]), $headers);
    }

    public function listPackages(
        array $headers = [],
        int $page = 1,
        int $perPage = 20,
        bool $descendingOrder = true,
        array $subjects = []
    ) : PromiseInterface {
        return $this->getRequest(
            Uri::fromParts([
                'path' => 'press-packages',
                'query' => build_query(array_filter([
                    'page' => $page,
                    'per-page' => $perPage,
                    'order' => $descendingOrder ? 'desc' : 'asc',
                    'subject[]' => $subjects,
                ])),
            ]),
            $headers
        );
    }
}
