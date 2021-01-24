#!/bin/bash

# include common backup script
. "$(dirname "$0")/common_backup.sh"

# get latest backup file
unset -v LATEST_FILE
for file in "$BACKUPS_DIR"/*.sql; do
  [[ $file -nt $LATEST_FILE ]] && LATEST_FILE=$file
done

# print variables
echo "LATEST_FILE     ${LATEST_FILE}"

# run docker backup restore command
cat "$LATEST_FILE" | docker exec -i "$DOCKER_CONTAINER" /usr/bin/mysql -u"$MYSQL_USER" -p"$MYSQL_PASSWORD" "$MYSQL_DATABASE"
