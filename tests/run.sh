#!/usr/bin/env bash
./vendor/bin/tester ./tests -c ./tests/php-unix.ini --setup ./tests/setup.php -p php-cgi -s
