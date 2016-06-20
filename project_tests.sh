#!/bin/bash
set -e

if [ "$dependencies" = "lowest" ]; then composer update --prefer-lowest --no-interaction; else composer update --no-interaction; fi;
(vendor/bin/phpspec run --format=junit > build/phpspec.xml) && echo "PHPSpec tests passed - see build/phpspec.xml log"
vendor/bin/phpunit
