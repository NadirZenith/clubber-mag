#!/bin/bash

chown -R www-data:www-data wp-content/;

# execute bash script from official wordpress image
source /usr/local/bin/docker-entrypoint.sh "$@";
