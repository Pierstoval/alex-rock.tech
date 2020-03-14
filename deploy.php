<?php

namespace Deployer;

require 'recipe/symfony4.php';

set('application', 'alex-rock.tech');
set('repository', 'git@github.com:Pierstoval/piers.tech.git');
set('composer_options', '{{composer_action}} -vna --prefer-dist --no-progress --no-dev --no-scripts');
set('allow_anonymous_stats', false);
set('default_stage', 'prod');
set('env', [
    'APP_ENV' => 'prod',
]);

host('alex-rock.tech')
    ->user('pierstoval')
    ->stage('prod')
    ->set('deploy_path', '/var/www/alex-rock.tech/deploy')
    ->addSshFlag('-t')
    ->addSshOption('StrictHostKeyChecking', 'no')
    ->forwardAgent(true)
    ->addSshOption('UserKnownHostsFile', '/dev/null')
    ->multiplexing(true)
;

task('assets', <<<TASK
    npm install
    npm run dev
    TASK
);

after('deploy:symlink', 'assets');

before('deploy:symlink', 'database:migrate');

