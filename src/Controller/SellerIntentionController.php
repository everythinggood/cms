<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/25/18
 * Time: 12:39 AM
 */

namespace Cms\Controller;


use Cms\Helper\ValidationHelper;
use Cms\Service\SellerIntentionService;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class SellerIntentionController
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
        $addition = $request->getParam('addition');
        $additionType = $request->getParam('additionType');
        $intention = $request->getParam('intention');
        $intentionType = $request->getParam('intentionType');
        $memo = $request->getParam('memo');

        ValidationHelper::checkIsNull($userName,'userName');
        ValidationHelper::checkIsNull($phone,'phone');
        ValidationHelper::checkIsNull($address,'address');
        ValidationHelper::checkIsNull($intention,'intention');
        ValidationHelper::checkIsNull($intentionType,'intentionType');

        $sellerIntentionService = new SellerIntentionService($this->container->get(EntityManager::class));

        $sellerIntention = $sellerIntentionService->createSellerIntention(
            compact('userName','phone','address',
                'addition','additionType','intentionType','intention','memo'));

        ValidationHelper::checkIsTrue($sellerIntention,'create SellerIntention fail!');
        /** @var Response $response */
        return $response->withJson([
            'sellerIntention'=>$sellerIntention
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

        $sellerIntentionService = new SellerIntentionService($this->container->get(EntityManager::class));

        $sellerIntentions = $sellerIntentionService->findAll();

        ValidationHelper::checkIsTrue($sellerIntentions,'sellerIntentions is empty!');
        /** @var Response $response */
        return $response->withJson([
            'data'=>$sellerIntentions
        ],200);

    }


}