#!/bin/bash

DIR=$(dirname "$0")

cd "${DIR}"/..

sudo service php7.4-fpm stop
composer install --no-interaction --no-progress --classmap-authoritative --no-dev --no-scripts
php bin/console cache:clear --no-warmup
sudo service php7.4-fpm restart
php bin/console cache:warmup
php bin/console assets:install
php bin/console --no-interaction doctrine:migrations:migrate

npm install
npm run build
