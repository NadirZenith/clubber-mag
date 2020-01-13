#!/bin/sh
set -e

chmod -R 777 web/wp-content/uploads

php-fpm;

