<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 7/28/18
 * Time: 10:34 AM
 */
require __DIR__ . '/../../vendor/autoload.php';

// Instantiate the app
$settings = require __DIR__ . '/../../src/settings.php';
$app = new \Slim\App($settings);
$container = $app->getContainer();

// Set up dependencies
require __DIR__ . '/../../src/dependencies.php';

/** @var \Doctrine\ORM\EntityManager $em */
$em = $app->getContainer()->get(\Doctrine\ORM\EntityManager::class);

$workService = new \Cms\Service\WorkService($em);

$data = [
    'author' => 'ycy1',
    'city' => '广州',
    'phone' => '13751821625',
    'weixin' => 'ycy1',
    'name' => 'test',
    'description' => 'test',
    'wxOpenId' => 'o0xto1NmaRm3ESdgiAiA0NaNg3WM'
];

$work = $workService->createWork($data);
var_dump($work);


