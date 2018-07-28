<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 7/28/18
 * Time: 10:23 AM
 */

namespace Cms\Controller;


use Cms\Service\WeChatUserService;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Container;
use Slim\Http\Response;

class WeChatUserController
{
    /**
     * @var WeChatUserService
     */
    private $weChatUserService;

    /**
     * WeChatUserController constructor.
     * @param Container $container
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function __construct(Container $container)
    {
        $em = $container->get(EntityManager::class);
        $this->weChatUserService = new WeChatUserService($em);
    }

    public function users(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        /** @var Response $response */
        $users = $this->weChatUserService->findAll();

        return $response->withJson([
            'data'=>$users
        ]);
    }


}