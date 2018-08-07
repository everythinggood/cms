<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

$container[\Doctrine\ORM\EntityManager::class] = function (\Slim\Container $container): \Doctrine\ORM\EntityManager {
    $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
        $container['settings']['doctrine']['metadata_dirs'],
        $container['settings']['doctrine']['dev_mode']
    );

    $config->setMetadataDriverImpl(
        new \Doctrine\ORM\Mapping\Driver\AnnotationDriver(
            new \Doctrine\Common\Annotations\AnnotationReader(),
            $container['settings']['doctrine']['metadata_dirs']
        )
    );

    $config->setMetadataCacheImpl(
        new \Doctrine\Common\Cache\FilesystemCache(
            $container['settings']['doctrine']['cache_dir']
        )
    );

    $em = \Doctrine\ORM\EntityManager::create(
        $container['settings']['doctrine']['connection'],
        $config
    );

    $platform = $em->getConnection()->getDatabasePlatform();
    $platform->registerDoctrineTypeMapping('enum', 'string');
    $platform->registerDoctrineTypeMapping('set', 'string');

    return $em;
};

/**
 * @param \Psr\Container\ContainerInterface $container
 * @return \SlimSession\Helper
 */
$container['session'] = function (\Psr\Container\ContainerInterface $container) {
    return new \SlimSession\Helper();
};

$container['errorHandler'] = function (\Psr\Container\ContainerInterface $container) {
    $handler = new \Cms\Handler\ErrorHandler();
    $handler->setLogger($container->get('logger'));
    return $handler;
};

$container['flash'] = function (\Psr\Container\ContainerInterface $container) {
    return new \Slim\Flash\Messages();
};

$container['sessionMiddleware'] = function (\Psr\Container\ContainerInterface $container) {

    $logger = $container->get('logger');
    $session = $container->get('session');
    $userService = new \Cms\Service\UserService($container->get(\Doctrine\ORM\EntityManager::class));

    return new \Cms\Middleware\SessionMiddleware($session, $userService, $logger);
};

$container['officialAccount'] = function (\Psr\Container\ContainerInterface $container) {
    $config = $container->get('settings')['wx_officialAccount_config'];

    $app = \EasyWeChat\Factory::officialAccount($config);

    return $app;
};

$container['weChatUserSessionMiddleware'] = function (\Psr\Container\ContainerInterface $container){
    $logger = $container->get('logger');
    $session = $container->get('session');
    $app = $container['officialAccount'];

    return new \Cms\Middleware\WeChatUserSessionMiddleware($session,$app,$logger);
};

$container['imageManager'] = function(\Psr\Container\ContainerInterface $container){
  return new \Intervention\Image\ImageManager(['driver'=>'imagick']);
};
