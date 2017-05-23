eLife API client for PHP
========================

[![Build Status](http://ci--alfred.elifesciences.org/buildStatus/icon?job=library-api-client-php)](http://ci--alfred.elifesciences.org/job/library-api-client-php/)

This library provides a PHP client for the [eLife Sciences API](https://github.com/elifesciences/api-raml).

Dependencies
------------

* PHP 7

You will need an implementation of `eLife\ApiClient\HttpClient`; the client provides an adapter for [Guzzle 6](http://guzzlephp.org/).

Installation
------------

Execute `composer require elife/api-client`.

Usage
-----

The `eLife\ApiClient\ApiClient` namespace provides separate clients for each part of the eLife API.

Each method on an API client represents an endpoint.

You can pass default headers to an API client, and/or to each API client method. You should provide an `Accept` header stating which versions you support.

API clients always return instances of `GuzzleHttp\Promise\PromiseInterface`, which wrap instances of `eLife\ApiClient\Result`, which in turn wrap the JSON response.

`eLife\ApiClient\Result` provides integration with the [JMESPath](http://jmespath.org/) (using [jmespath.php](https://github.com/jmespath/jmespath.php)), to allow easy searching of JSON responses.

### Basic example

To list the Labs Post numbers that appear on the first page of the endpoint:

```php
use eLife\ApiClient\ApiClient\LabsClient;
use eLife\ApiClient\HttpClient\Guzzle6HttpClient;
use eLife\ApiClient\MediaType;
use GuzzleHttp\Client as Guzzle;

$guzzle = new Guzzle(['base_uri' => 'https://api.elifesciences.org/']);
$httpClient = new Guzzle6HttpClient($guzzle);
$labsClient = new LabsClient($httpClient);

var_dump($labsClient->listPosts(['Accept' => new MediaType(LabsClient::TYPE_EXPERIMENT_LIST, 1)])->wait()->search('items[*].number'));
```

### Deprecation warnings

As the eLife API provides deprecation warnings using the HTTP `Warning` header, the `eLife\ApiClient\HttpClient\WarningCheckingHttpClient` will pass these to a [PSR-7 logger](http://www.php-fig.org/psr/psr-3/).
