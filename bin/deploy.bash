#!/bin/bash

DIR=$(dirname "$0")

cd "${DIR}"/..

composer install --no-interaction --no-progress --classmap-authoritative --no-dev --no-scripts
php bin/console cache:clear --no-warmup
sudo /etc/init.d/php7.4-fpm restart
php bin/console cache:warmup
php bin/console assets:install --symlink --relative

npm install
npm run build
