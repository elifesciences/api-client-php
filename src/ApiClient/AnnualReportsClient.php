<?php

namespace eLife\ApiClient\ApiClient;

use eLife\ApiClient\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Uri;
use function GuzzleHttp\Psr7\build_query;

final class AnnualReportsClient
{
    const TYPE_ANNUAL_REPORT = 'application/vnd.elife.annual-report+json';
    const TYPE_ANNUAL_REPORT_LIST = 'application/vnd.elife.annual-report-list+json';

    use ApiClient;

    public function getReport(array $headers, int $year) : PromiseInterface
    {
        return $this->getRequest(Uri::fromParts(['path' => "annual-reports/$year"]), $headers);
    }

    public function listReports(
        array $headers = [],
        int $page = 1,
        int $perPage = 20,
        bool $descendingOrder = true
    ) : PromiseInterface {
        return $this->getRequest(
            Uri::fromParts([
                'path' => 'annual-reports',
                'query' => build_query([
                    'page' => $page,
                    'per-page' => $perPage,
                    'order' => $descendingOrder ? 'desc' : 'asc',
                ]),
            ]),
            $headers
        );
    }
}
