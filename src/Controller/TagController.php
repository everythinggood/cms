<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/25/18
 * Time: 1:12 AM
 */

namespace Cms\Controller;


use Cms\Helper\ValidationHelper;
use Cms\Service\TagService;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class TagController
{
    /**
     * @var Container
     */
    private $container;

    /**
     * UserController constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return Response
     * @throws \Exception
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function add(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        /** @var Request $request */
        $name = $request->getParam('name');
        $type = $request->getParam('type');

        ValidationHelper::checkIsNull($name,'name');
        ValidationHelper::checkIsNull($type,'type');

        $tagService = new TagService($this->container->get(EntityManager::class));

        $tag = $tagService->createTag(compact('name','type'));

        ValidationHelper::checkIsTrue($tag,'create tag fail!');
        /** @var Response $response */
        return $response->withJson([
            'tag'=>$tag
        ],200);

    }


}