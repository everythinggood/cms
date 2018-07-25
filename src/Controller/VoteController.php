<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 7/24/18
 * Time: 4:45 PM
 */

namespace Cms\Controller;


use Cms\Constant\SessionConstant;
use Cms\Helper\ValidationHelper;
use Cms\Service\VoteService;
use Cms\Service\WorkService;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use SlimSession\Helper;

class VoteController
{

    /**
     * @var Container
     */
    private $container;
    /**
     * @var Helper
     */
    private $session;

    /**
     * VoteController constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->session = $container['session'];
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
        $wxOpenId = null;
        if ($wxUser = $this->session->get(SessionConstant::WECHAT_USER)){
            $wxOpenId = $wxUser['id'];
        }

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