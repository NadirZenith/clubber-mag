#!/bin/bash

git add . && git status && git commit -m fix && git push origin pre

ssh nzpro "
cd services/arbol/clubber-mag/;
docker-compose down;
git pull -X theirs --no-edit origin pre;
docker-compose up --build --abort-on-container-exit;
exit"
