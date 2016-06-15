#!/bin/bash
set -e

composer update --prefer-lowest --no-interaction
vendor/bin/phpspec run
vendor/bin/phpunit
