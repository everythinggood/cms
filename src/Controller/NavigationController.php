<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 6/19/18
 * Time: 3:13 PM
 */

namespace Cms\Controller;


use Cms\Helper\ValidationHelper;
use Cms\Service\NavigationService;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class NavigationController
{
    /**
     * @var Container
     */
    private $container;
    /**
     * @var NavigationService
     */
    private $navigationService;

    /**
     * NavigationController constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->navigationService = new NavigationService($this->container[EntityManager::class]);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return Response
     * @throws \Exception
     */
    public function add(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        /** @var Request $request */
        /** @var Response $response */
        $name = $request->getParam('name');
        $zIndex = $request->getParam('zIndex') ?: 0;
        $inheritId = $request->getParam('inheritId');
        $href = $request->getParam('href');

        ValidationHelper::checkIsNull($name, 'name');
        ValidationHelper::checkIsNull($href, 'href');

        $navigation = $this->navigationService->addNavigation(compact('name', 'zIndex', 'inheritId', 'href'));

        return $response->withJson([
            'navigation' => $navigation
        ], 200);

    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return Response
     * @throws \Exception
     */
    public function edit(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        /** @var Request $request */
        /** @var Response $response */
        $id = $request->getParam('id');
        $name = $request->getParam('name');
        $zIndex = $request->getParam('zIndex') ?: 0;
        $inheritId = $request->getParam('inheritId');
        $href = $request->getParam('href');

        ValidationHelper::checkIsNull($id, 'id');
        ValidationHelper::checkIsNull($name, 'name');
        ValidationHelper::checkIsNull($zIndex, 'zIndex');
        ValidationHelper::checkIsNull($href, 'href');

        $navigation = $this->navigationService->editNavigation($id, compact('name', 'zIndex', 'inheritId', 'href'));

        return $response->withJson([
            'navigation' => $navigation
        ], 200);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return Response
     * @throws \Exception
     */
    public function remove(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        /** @var Request $request */
        /** @var Response $response */
        $id = $request->getParam('id');

        ValidationHelper::checkIsNull($id,'id');

        $flag = $this->navigationService->deleteById($id);

        return $response->withJson([
            'flag' => $flag
        ], 200);
    }

    public function navigationArr(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        /** @var Response $response */
        $navigationArr = $this->navigationService->findAll();

        return $response->withJson([
            'navigationArr' => $navigationArr
        ], 200);
    }

    public function navigationList(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $navigationList = $this->navigationService->all();
        /** @var Response $response */
        return $response->withJson([
            'data' => $navigationList
        ], 200);
    }

    public function find(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $id = $args['id'];
        /** @var Request $request */
        /** @var Response $response */
        $navigation = $this->navigationService->findById($id);

        return $response->withJson([
            'navigation' => $navigation
        ], 200);
    }

}