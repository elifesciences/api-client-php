eLife API client for PHP
========================

This library provides a PHP client for the [eLife Sciences API](https://github.com/elifesciences/api-raml).

Dependencies
------------

* PHP 7

You will need an implementation of `eLife\ApiClient\HttpClient`; the client provides an adapter for [Guzzle 6](http://guzzlephp.org/).

Installation and usage 
----------------------

This library provides base HTTP functionality for the classes available in [`elife/api-sdk-php`](https://github.com/elifesciences/api-sdk-php). Please use that package instead of consuming this directly.

If you do want to use it, you can do so via composer, e.g. `composer require elife/api-client`.

### Deprecation warnings

As the eLife API provides deprecation warnings using the HTTP `Warning` header, the `eLife\ApiClient\HttpClient\WarningCheckingHttpClient` will pass these to a [PSR-7 logger](http://www.php-fig.org/psr/psr-3/).
