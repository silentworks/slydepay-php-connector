#!/bin/bash

php -v && composer -V && composer install --prefer-dist

./vendor/bin/kahlan --cc --reporter=bar