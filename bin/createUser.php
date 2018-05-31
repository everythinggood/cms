<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/31/18
 * Time: 5:24 PM
 */

require __DIR__ . '/../vendor/autoload.php';

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);
$container = $app->getContainer();

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

/** @var \Doctrine\ORM\EntityManager $em */
$em = $app->getContainer()->get(\Doctrine\ORM\EntityManager::class);

$user = new \Cms\Entity\User();
$user->setName('ycy1');
$user->setPassword(base64_encode(md5('ycy1')));
$user->setRole('admin');
$user->setCreateTime(new DateTime());
$user->setUpdateTime(new DateTime());

$em->persist($user);
$em->flush();

