#!/bin/bash

echo "[DEPLOY] > Starting deployment..."

set -e

# Project's root directory
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

##
## Git retrieval
##

echo "[DEPLOY] > Retrieve distant changes"

cd "${DIR}"

git fetch --all --prune
git reset --hard origin/main

##
## Backend deploy
##

echo "[DEPLOY] > Deploying backend"

cd "${DIR}/backend/"

export APP_ENV=prod
export APP_DEBUG=0

# Used to dump a new autoloader because classmap will make autoload fail if some new classes are created between deploys
composer dump-autoload --no-dev

composer install \
    --no-dev \
    --no-scripts \
    --prefer-dist \
    --optimize-autoloader \
    --apcu-autoloader \
    --classmap-authoritative \
    --no-progress \
    --no-ansi \
    --no-interaction

php bin/console cache:clear --no-warmup
php bin/console cache:warmup

##
## Frontend deploy
##

echo "[DEPLOY] > Deploying frontend"

cd "${DIR}/frontend/"

yarn install \
  --pure-lockfile \
  --non-interactive \

export NODE_ENVIRONMENT=production
export NODE_ENV=production

yarn build

##

# Go back to project
cd "${DIR}"

##
## Post-deploy infra-specific scripts
## (usually used to reload a web-server, for instance)
##

if [[ -f "${DIR}/../post_deploy.bash" ]]
then
    echo "[DEPLOY] > Executing post-deploy scripts"
    bash "${DIR}/../post_deploy.bash" ${NEW_VERSION} ${CHANGELOG_FILE}
fi

echo "[DEPLOY] > Done!"
