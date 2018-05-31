<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/31/18
 * Time: 10:16 AM
 */

require __DIR__ . '/../vendor/autoload.php';

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

$questionService = new \Cms\Service\QuestionService($app->getContainer()->get(\Doctrine\ORM\EntityManager::class));

$questions = $questionService->findByCategory('default');

var_dump($questions);