<?php

$env = new Dotenv\Dotenv(__DIR__.'/../');
$env->load();

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'debug'=>$_ENV['slim_debug'],
        'routerCacheFile'=>false,

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'cms',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        'doctrine' => [
            // if true, metadata caching is forcefully disabled
            'dev_mode' => true,

            // path where the compiled metadata info will be cached
            // make sure the path exists and it is writable
            'cache_dir' => __DIR__ . '/../cache',

            // you should add any other path containing annotated entity classes
            'metadata_dirs' => [__DIR__ . '/Entity'],

            'connection' => [
                'driver' => $_ENV['connect_driver'],
                'host' => $_ENV['connect_host'],
                'port' => $_ENV['connect_port'],
                'dbname' => $_ENV['connect_dbname'],
                'user' => $_ENV['connect_user'],
                'password' => $_ENV['connect_password'],
                'charset' => $_ENV['charset'],
            ]
        ],

        'upload_file_directory'=> __DIR__ . '/../public/uploads'
    ],
];
