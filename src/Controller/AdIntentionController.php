<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/24/18
 * Time: 5:59 PM
 */

namespace Cms\Controller;


use Cms\Helper\ValidationHelper;
use Cms\Service\AdIntentionService;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class AdIntentionController
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
    public function add(ServerRequestInterface $request, ResponseInterface $response, array $args){
        /** @var Request $request */
        $userName = $request->getParam('userName');
        $phone = $request->getParam('phone');
        $address = $request->getParam('address');
        $adType = $request->getParam('adType');
        $adMoney = $request->getParam('adMoney');
        $intention = $request->getParam('intention');

        ValidationHelper::checkIsNull($userName,'userName');
        ValidationHelper::checkIsNull($phone,'phone');
        ValidationHelper::checkIsNull($address,'address');
        ValidationHelper::checkIsNull($adType,'adType');
        ValidationHelper::checkIsNull($intention,'intention');

        $adIntentionService = new AdIntentionService($this->container->get(EntityManager::class));

        $adIntention = $adIntentionService->createAdIntention(compact('userName','phone','address','adType','adMoney','intention'));

        ValidationHelper::checkIsTrue($adIntention,'create adIntention fail!');
        /** @var Response $response */
        return $response->withJson([
            'adIntention'=>$adIntention
        ],200);

    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return Response
     * @throws \Interop\Container\Exception\ContainerException
     * @throws \Exception
     */
    public function findAll(ServerRequestInterface $request, ResponseInterface $response, array $args){
        /** @var Request $request */

        $adIntentionService = new AdIntentionService($this->container->get(EntityManager::class));

        $adIntentions = $adIntentionService->findAll();

        ValidationHelper::checkIsTrue($adIntentions,'adIntentions is empty');

        /** @var Response $response */
        return $response->withJson([
            'data'=>$adIntentions
        ],200);

    }


}