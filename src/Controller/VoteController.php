<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 7/24/18
 * Time: 4:45 PM
 */

namespace Cms\Controller;


use Cms\Helper\ValidationHelper;
use Cms\Service\VoteService;
use Cms\Service\WorkService;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class VoteController
{

    /**
     * @var Container
     */
    private $container;

    /**
     * VoteController constructor.
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
        $id = $request->getParam('id');
        $wxOpenId = $request->getParam('wxOpenId','wx_12311');

        ValidationHelper::checkIsNull($id,'id');

        /** @var EntityManager $em */
        $em = $this->container->get(EntityManager::class);
        $workService = new WorkService($em);

        $work = $workService->findById($id);

        ValidationHelper::checkIsTrue($work,'work can not be found!');

        $voteService = new VoteService($em);

        $vote = $voteService->createVote($work->id,$wxOpenId);

        ValidationHelper::checkIsTrue($vote,'vote is exist!can not add.');

        /** @var Response $response*/
        return $response->withJson([
            'vote'=>$vote
        ]);


    }


}