<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/25/18
 * Time: 1:05 AM
 */

namespace Cms\Controller;


use Cms\Helper\ValidationHelper;
use Cms\Service\UserFeedBackService;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class UserFeedBackController
{
    /**
     * @var Container
     */
    private $container;
    /**
     * @var UserFeedBackService
     */
    private $userFeedbackService;

    /**
     * UserController constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->userFeedbackService = new UserFeedBackService($container[EntityManager::class]);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return Response
     * @throws \Exception
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function add(ServerRequestInterface $request, ResponseInterface $response, array  $args)
    {
        /** @var Request $request */
        $userName = $request->getParam('userName');
        $address = $request->getParam('address');
        $machineCode = $request->getParam('machineCode');
        $phone = $request->getParam('phone');
        $qDescription = $request->getParam('qDescription');
        $qType = $request->getParam('qType');
        $wxId = $request->getParam('wxId');

        ValidationHelper::checkIsNull($userName,'userName');
        ValidationHelper::checkIsNull($wxId,'wxId');
        ValidationHelper::checkIsNull($machineCode,'machineCode');
        ValidationHelper::checkIsNull($phone,'phone');
        ValidationHelper::checkIsNull($qType,'qType');

        $userFeedbackService = new UserFeedBackService($this->container->get(EntityManager::class));
        $userFeedback = $userFeedbackService->createUserFeedback(compact('userName','address','machineCode',
            'phone','qDescription','qType','qDescription','wxId'));

        ValidationHelper::checkIsTrue($userFeedback,'create UserFeedback fail!');
        /** @var Response $response */
        return $response->withJson([
            'userFeedback'=>$userFeedback
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

        $userFeedbackService = new UserFeedBackService($this->container->get(EntityManager::class));

        $userFeedbacks = $userFeedbackService->findAll();

        ValidationHelper::checkIsTrue($userFeedbacks,'userFeedbacks is empty');

        /** @var Response $response */
        return $response->withJson([
            'data'=>$userFeedbacks
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

        $flag = $this->userFeedbackService->handle($id);

        /** @var Response $response */
        return $response->withJson([
            'handle'=>$flag
        ],200);

    }

}