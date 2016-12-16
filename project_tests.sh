#!/bin/bash
set -e

# delete leftover files from other branches
git clean -df

: "${dependencies:?Need to set dependencies environment variable}"
if [ "$dependencies" = "lowest" ]; then
    composer update --prefer-lowest --no-interaction
    proofreader spec/ src/ test/
else
    composer update --no-interaction
fi
(vendor/bin/phpspec run --format=junit | tee build/${dependencies}-phpspec.xml) && echo "PHPSpec tests passed - see build/phpspec.xml log"
vendor/bin/phpunit --log-junit="build/${dependencies}-phpunit.xml"
