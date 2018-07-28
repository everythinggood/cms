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

$wechatUserService = new \Cms\Service\WeChatUserService($em);

$data = [
    'city'=>'广州',
    'country'=>'中国',
    'province'=>'广东',
    'headimgurl'=>'http://thirdwx.qlogo.cn/mmopen/vi_32/VnIMsE83cfNCyJuO9KyhiaGyboMNUnJicdfCQzUpjd3D1XRk01c6t6fsXUEhxLYX426PBW6om5bWuiaILHibIdn3cw/132',
    'nickname'=>'Ray',
    'openid'=>'o0xto1NmaRm3ESdgiAiA0NaNg3WM',
    'id'=>'o0xto1NmaRm3ESdgiAiA0NaNg3WM',
    'sex'=>'1'
];

$user = $wechatUserService->createWeChatUser($data);
var_dump($user);


