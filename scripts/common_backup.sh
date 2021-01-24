#!/bin/bash

# function to get variables from .env file
read_var() {
    VAR=$(grep "$1" "$2" | xargs)
    IFS="=" read -ra VAR <<< "$VAR"
    echo "${VAR[1]}"
}

# build needed directories
SCRIPT_DIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )
ENV_FILE=$( realpath "${SCRIPT_DIR}/../.env" )
BACKUPS_DIR=$( realpath "${SCRIPT_DIR}/../backups" )

# create backups dir if it does not exist
[ -d "$BACKUPS_DIR" ] || mkdir "$BACKUPS_DIR"

# build needed variables
MYSQL_USER=$(read_var MYSQL_USER "$ENV_FILE" )
MYSQL_PASSWORD=$(read_var MYSQL_PASSWORD "$ENV_FILE" )
MYSQL_DATABASE=$(read_var MYSQL_DATABASE "$ENV_FILE" )
DOCKER_CONTAINER=$(read_var MYSQL_HOST "$ENV_FILE" )

# print variables
echo "DB:             ${MYSQL_DATABASE}"
echo "USER:           ${MYSQL_USER}"
echo "PASS:           ${MYSQL_PASSWORD}"
echo "CONTAINER_HOST  ${DOCKER_CONTAINER}"
