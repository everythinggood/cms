<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 7/25/18
 * Time: 11:08 AM
 */

namespace Cms\Middleware;


use Cms\Constant\SessionConstant;
use EasyWeChat\OfficialAccount\Application;
use Monolog\Logger;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Request;
use SlimSession\Helper;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;

class WeChatUserSessionMiddleware
{

    /**
     * @var Helper
     */
    private $session;
    /**
     * @var Application
     */
    private $app;
    /**
     * @var Logger
     */
    private $logger;

    /**
     * WeChatUserSessionMiddleware constructor.
     * @param Helper $session
     * @param Application $app
     * @param Logger $logger
     */
    public function __construct(Helper $session, Application $app, Logger $logger)
    {
        $this->session = $session;
        $this->app = $app;
        $this->logger = $logger;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $next
     * @return ResponseInterface|\Zend\Diactoros\Response|static
     */
    public function __invoke($request, $response, $next)
    {
        /** @var Request  $request */
        $uri = $request->getUri();
        $path = $uri->getPath();

        $this->session->set(SessionConstant::WECHAT_TARGET_URL,$path);

        $weChatUser = $this->session->get(SessionConstant::WECHAT_USER);

        if(!$weChatUser){
            $syResponse = $this->app->oauth->redirect();
            $this->logger->addInfo(WeChatUserSessionMiddleware::class,(array)$this->app->oauth->getRedirectUrl());

            $factory = new DiactorosFactory();
            return $factory->createResponse($syResponse);
        }

        return $next($request,$response);

    }


}