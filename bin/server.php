<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}
require __DIR__ . '/../vendor/autoload.php';


// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';

$bridgeManager = new \Pachico\SlimSwoole\BridgeManager($app);

$http_server = new swoole_http_server('0.0.0.0', 8888);
//开启静态资源 对文件名有一定要求，不能有空格
$http_server->set([
    'enable_static_handler' => true,
    'document_root' => __DIR__ . '/../public'
]);


$http_server->on('onWorkerStart', function (swoole_http_request $request, swoole_http_response $response) {

});

$http_server->on('start', function (swoole_http_server $http_server) {
    echo sprintf('Swoole http server is started at http://%s:%s', $http_server->host, $http_server->port);
});
$http_server->on('request', function (swoole_http_request $request, swoole_http_response $response) use ($bridgeManager) {
    $bridgeManager->process($request, $response)->end();
});
$http_server->start();
