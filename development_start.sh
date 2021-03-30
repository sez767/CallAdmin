#!/bin/bash
docker-compose down --remove-orphans
docker-compose up --build -d
docker-compose run --rm npm install 
docker-compose exec app chmod -R a+x node_modules

if [ ! -z $1 ]; then
  docker-compose exec app php artisan key:generate
  docker-compose exec app php artisan passport:install
  docker-compose exec app php artisan storage:link
fi

docker-compose run --rm npm run watch -d

