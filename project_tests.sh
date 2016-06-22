#!/bin/bash
set -e

: "${dependencies:?Need to set dependencies environment variable}"
if [ "$dependencies" = "lowest" ]; then composer update --prefer-lowest --no-interaction; else composer update --no-interaction; fi;
(vendor/bin/phpspec run --format=junit | tee build/${dependencies}-phpspec.xml) && echo "PHPSpec tests passed - see build/phpspec.xml log"
vendor/bin/phpunit --log-junit="build/${dependencies}-phpunit.xml"
