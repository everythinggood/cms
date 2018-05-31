<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/24/18
 * Time: 11:35 AM
 */

require __DIR__ . '/../vendor/autoload.php';

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);
$container = $app->getContainer();

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

\Doctrine\ORM\Tools\Console\ConsoleRunner::run(
    \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($container[\Doctrine\ORM\EntityManager::class])
);
