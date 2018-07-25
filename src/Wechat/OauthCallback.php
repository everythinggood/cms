<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 7/25/18
 * Time: 11:05 AM
 */

namespace Cms\Wechat;


use Cms\Service\WeChatUserService;
use Doctrine\ORM\EntityManager;
use EasyWeChat\OfficialAccount\Application;
use Monolog\Logger;
use Overtrue\Socialite\User;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Container;
use Slim\Http\Response;
use SlimSession\Helper;

class OauthCallback
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
     * @var Container
     */
    private $container;
    /**
     * @var WeChatUserService
     */
    private $weChatUserService;

    /**
     * OauthCallback constructor.
     * @param Container $container
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->session = $container['session'];
        $this->app = $container['officialAccount'];
        $this->logger = $container['logger'];
        $this->weChatUserService = new WeChatUserService($container->get(EntityManager::class));
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function officialAccount(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {

        $targetUrl = $this->session->get('wechat_target_url') ?: '/activity/work/add';

        $weChatUser = $this->session->get('wechat_user');
        if (!$weChatUser) {
            /** @var User $wxUser */
            $wxUser = $this->app->oauth->user();
            $this->logger->addInfo(OauthCallback::class,$wxUser->toArray());
            if ($weChatUser = $this->weChatUserService->createWeChatUser($wxUser->toArray())) {
                $this->logger->addInfo(OauthCallback::class, (array)$weChatUser);
            }

            $this->session->set('wechat_user', $wxUser);
        }

        /** @var Response $response */
        return $response->withRedirect($targetUrl);
    }


}