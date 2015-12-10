#!/usr/bin/env bash
./vendor/bin/tester ./tests/$1 -c ./tests/php-local.ini --setup ./tests/setup.php -p php-cgi -s
