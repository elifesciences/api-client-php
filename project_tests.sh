#!/bin/bash
set -e

vendor/bin/phpspec run
vendor/bin/phpunit --log-junit="build/${dependencies}-phpunit.xml"
