#!/bin/bash

# @todo keep only X last backup files

# include common backup script
. "$(dirname "$0")/common_backup.sh"

# build variables
BACKUP_DATETIME=$(date '+%d%m%y_%H%M%S' )
BACKUP_FILE="${BACKUPS_DIR}/${BACKUP_DATETIME}.sql"

# print variables
echo "DATE_TIME       ${BACKUP_DATETIME}"
echo "FILE            ${BACKUP_FILE}"

# run docker backup command
docker exec "$DOCKER_CONTAINER" /usr/bin/mysqldump -u"$MYSQL_USER" -p"$MYSQL_PASSWORD" "$MYSQL_DATABASE" > "$BACKUP_FILE"
