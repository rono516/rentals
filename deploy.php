<?php

namespace Deployer;

require 'recipe/laravel.php';
// require 'contrib/npm.php';
require 'contrib/rsync.php';

set('application', 'Drash Website');
set('repository', 'git@github.com:nwaweru/drash-rentals.git');
set('ssh_multiplexing', true);

set('rsync_src', function () {
    return __DIR__; // If your project isn't in the root, you'll need to change this.
});

// Configuring the rsync exclusions.
// You'll want to exclude anything that you don't want on the production server.
add('rsync', [
    'exclude' => [
        '.git',
        '/vendor/',
        '/node_modules/',
        '.github',
        'deploy.php',
    ],
]);

host('prod')
    ->setHostname('drash.co.ke')
    ->set('remote_user', 'nwaweru')
    ->set('identity_file', '~/.ssh/id_rsa')
    ->set('branch', 'master')
    ->set('deploy_path', '/var/www/drash-rentals');

after('deploy:failed', 'deploy:unlock');

desc('Start deploying the application...');

task('deploy', [
    'deploy:prepare',
    'rsync',
    'deploy:vendors',
    'deploy:shared',
    'artisan:storage:link',
    'artisan:view:cache',
    // 'artisan:config:cache',
    'artisan:config:clear',
    'artisan:migrate',
    'artisan:queue:restart',
    'deploy:publish',
]);

desc('End deploying the application.');
