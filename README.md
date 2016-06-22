eLife API SDK for PHP
=====================

[![Build Status](http://ci.alfred.elifesciences.org/buildStatus/icon?job=library-api-sdk-php)](http://ci.alfred.elifesciences.org/job/library-api-sdk-php/)

This library provides a PHP SDK for the [eLife Sciences API](https://github.com/elifesciences/api-raml).

Dependencies
------------

* PHP 7

You will need an implementation of `eLife\ApiSdk\HttpClient`; the SDK provides an adapter for [Guzzle 6](http://guzzlephp.org/).

Installation
------------

Execute `composer require elife/api-sdk`.

Usage
-----

The `eLife\ApiSdk\ApiClient` namespace provides separate clients for each part of the eLife API.

Each method on an API client represents an endpoint. The method arguments are the arguments that the endpoint accepts, though the first argument is *always* the version of the JSON response that you will accept.

API clients always return instances of `GuzzleHttp\Promise\PromiseInterface`, which wrap instances of `eLife\ApiSdk\Result`, which in turn wrap the JSON response.

`eLife\ApiSdk\Result` provides integration with the [JMESPath](http://jmespath.org/) (using [jmespath.php](https://github.com/jmespath/jmespath.php)), to allow easy searching of JSON responses.

### Basic example

To list the Labs Experiment numbers that appear on the first page of the endpoint:

```php
use eLife\ApiSdk\ApiClient\LabsClient;
use eLife\ApiSdk\HttpClient\Guzzle6HttpClient;
use GuzzleHttp\Client as Guzzle;

$guzzle = new Guzzle(['base_uri' => 'https://api.elifesciences.org/']);
$httpClient = new Guzzle6HttpClient($guzzle);
$labsClient = new LabsClient($httpClient);

var_dump($labsClient->listExperiments(1)->wait()->search('items[*].number'));
```

### Deprecation warnings

As the eLife API provides deprecation warnings using the HTTP `Warning` header, the `eLife\ApiSdk\HttpClient\WarningCheckingHttpClient` will pass these to a [PSR-7 logger](http://www.php-fig.org/psr/psr-3/).
