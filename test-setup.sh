#!/bin/bash

cd slydepay_php

php -v

composer -V

composer install --prefer-dist

./vendor/bin/kahlan --cc --reporter=bar