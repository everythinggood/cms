<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 7/24/18
 * Time: 5:47 PM
 */

namespace Cms\Controller;

use Cms\Helper\ValidationHelper;
use Cms\Service\ChartsService;
use Cms\Service\WeChatUserService;
use Cms\Service\WorkImageService;
use Cms\Service\WorkService;
use Cms\View\WorkVote;
use Cms\View\WorkVoteAndUser;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Container;
use Slim\Http\Response;

/**
 * Class ChartsController
 * @package Cms\Controller
 */
class ChartsController
{

    /**
     * @var Container
     */
    private $container;

    /**
     * ChartsController constructor.
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
     * @throws \Interop\Container\Exception\ContainerException
     * @throws \Exception
     */
    public function top100(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        /** @var EntityManager $em */
        $em = $this->container->get(EntityManager::class);

        $chartsService = new ChartsService($em);
        $workService = new WorkService($em);
        $workImageService = new WorkImageService($em);

        $top = $chartsService->getTop100();

        ValidationHelper::checkIsTrue($top, 'can not found top100');

        $resultTop = [];
        foreach ($top as $position => $topItem) {
            $position = $position + 1;
            $id = $topItem['workNo'];
            $voteNum = $topItem['voteNum'];
            $work = $workService->findById($id);
            $workImage = $workImageService->findByWorkNo($id);
            $workVote = WorkVote::convertByWorkAndWorkImageAndVote($work, $workImage, $position, $voteNum);
            $resultTop[] = $workVote;
        }

        /** @var Response $response */
        return $response->withJson([
            'top' => $resultTop
        ]);

    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return Response
     * @throws \Exception
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function tops(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {

        /** @var EntityManager $em */
        $em = $this->container->get(EntityManager::class);

        $chartsService = new ChartsService($em);
        $workService = new WorkService($em);
        $workImageService = new WorkImageService($em);
        $wechatUserService = new WeChatUserService($em);

        $top = $chartsService->getTops();

        ValidationHelper::checkIsTrue($top, 'can not found tops');

        $resultTop = [];
        foreach ($top as $position => $topItem) {
            $position = $position + 1;
            $id = $topItem['workNo'];
            $voteNum = $topItem['voteNum'];
            $work = $workService->findById($id);
            $workImage = $workImageService->findByWorkNo($id);
            $user = $wechatUserService->findByOpenId($work->wxOpenId);
            $workVote = WorkVoteAndUser::convertByWorkAndWorkImageAndVoteAndUser($work, $workImage, $position, $voteNum,$user);
            $resultTop[] = $workVote;
        }

        /** @var Response $response */
        return $response->withJson([
            'data' => $resultTop
        ]);
    }


}