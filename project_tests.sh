#!/bin/bash
set -e

if [ "$dependencies" = "lowest" ]; then composer update --prefer-lowest --no-interaction; else composer update --no-interaction; fi;
vendor/bin/phpspec run
vendor/bin/phpunit
