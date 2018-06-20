<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/25/18
 * Time: 12:55 AM
 */

namespace Cms\Controller;


use Cms\Helper\ValidationHelper;
use Cms\Service\SellerFeedBackService;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class SellerFeedBackController
{
    /**
     * @var Container
     */
    private $container;
    /**
     * @var SellerFeedBackService
     */
    private $sellerFeedbackService;

    /**
     * UserController constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->sellerFeedbackService = new SellerFeedBackService($container[EntityManager::class]);
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
        $qType = $request->getParam('qType');
        $qDescription = $request->getParam('qDescription');
        $phone = $request->getParam('phone');
        $address = $request->getParam('address');
        $qDetail = $request->getParam('qDetail');
        $additionType = $request->getParam('additionType');
        $addition = $request->getParam('addition');
        $memo = $request->getParam('memo');

        ValidationHelper::checkIsNull($userName,'userName');
        ValidationHelper::checkIsNull($phone,'phone');
        ValidationHelper::checkIsNull($qType,'qType');
        ValidationHelper::checkIsNull($qDescription,'qDescription');
        ValidationHelper::checkIsNull($qDetail,'qDetail');

        $sellerFeedbackService = new SellerFeedBackService($this->container->get(EntityManager::class));
        $sellerFeedback = $sellerFeedbackService->createSellerFeedback(compact('userName','qType','qDetail',
            'qDescription','address','phone','additionType','addition','memo'));

        ValidationHelper::checkIsTrue($sellerFeedback,'create sellerFeedback fail!');
        /** @var Response $response */
        return $response->withJson([
            'sellerFeedback'=>$sellerFeedback
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

        $sellerFeedbackService = new SellerFeedBackService($this->container->get(EntityManager::class));

        $sellerFeedbacks = $sellerFeedbackService->findAll();

        ValidationHelper::checkIsTrue($sellerFeedbacks,'sellerFeedback is empty');

        /** @var Response $response */
        return $response->withJson([
            "data"=>$sellerFeedbacks
        ],200);

    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return Response
     * @throws \Exception
     */
    public function handle(ServerRequestInterface $request, ResponseInterface $response, array $args){

        /** @var Request $request */
        $id = $request->getParam('id');

        $sellerFeedback = $this->sellerFeedbackService->handle($id);

        /** @var Response $response */
        return $response->withJson([
            $sellerFeedback
        ],200);
    }


}