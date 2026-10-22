#!/bin/bash

docker run --rm -v ${PWD}:/var/www/project -w /var/www/project php php vendor/bin/phpunit
docker run --rm -v ${PWD}:/var/www/project -w /var/www/project php php vendor/bin/pint --test
