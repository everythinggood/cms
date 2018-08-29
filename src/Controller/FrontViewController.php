<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/29/18
 * Time: 2:55 PM
 */

namespace Cms\Controller;


use Cms\Constant\SessionConstant;
use Cms\Helper\DateHelper;
use Cms\Helper\ValidationHelper;
use Cms\Service\ChartsService;
use Cms\Service\QuestionService;
use Cms\Service\VoteService;
use Cms\Service\WorkImageService;
use Cms\Service\WorkService;
use Cms\View\WorkVote;
use Doctrine\ORM\EntityManager;
use EasyWeChat\OfficialAccount\Application;
use Monolog\Logger;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;
use SlimSession\Helper;

class FrontViewController
{

    /**
     * @var Container
     */
    private $container;
    /**
     * @var PhpRenderer
     */
    private $view;
    /**
     * @var QuestionService
     */
    private $questionService;
    /**
     * @var Helper
     */
    private $session;
    /**
     * @var Logger
     */
    private $logger;
    /**
     * @var Application
     */
    private $app;

    /**
     * ViewController constructor.
     * @param Container $container
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->view = $container['renderer'];
        $this->questionService = new QuestionService($container->get(EntityManager::class));
        $this->session = $container['session'];
        $this->logger = $container['logger'];
        $this->app = $container['officialAccount'];
    }

    public function userFeedback(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        return $this->view->render($response, '/front/Q&A/userFeedback.phtml');
    }

    public function adIntention(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        return $this->view->render($response, '/front/cooperation/adIntention.phtml');
    }

    public function sellerIntention(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        return $this->view->render($response, '/front/cooperation/sellerIntention.phtml');
    }

    public function sellerFeedback(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        return $this->view->render($response, '/front/Q&A/sellerFeedback.phtml');
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     * @throws \Exception
     */
    public function sellerQuestions(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        /** @var Request $request */
        $category = $request->getParam('category');

        $questions = $this->questionService->findByCategory($category, 'seller');

        return $this->view->render($response, '/front/Q&A/sellerQuestions.phtml', compact('questions'));
    }

    public function userQuestions(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {

        $questions = $this->questionService->getUserQuestions();

        return $this->view->render($response, '/front/Q&A/userQuestions.phtml', compact('questions'));
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function sellerTopQuestions(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {

        /** @var Request $request */
        $type = $args['type'] ?: 'seller';

        $topQuestions = $this->questionService->getTopQuestions($type);

        return $this->view->render($response, '/front/Q&A/sellerTopQuestions.phtml', compact('topQuestions'));
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function sellerQuestionCategorys(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {

        $categorys = $this->questionService->getCategorys();

        return $this->view->render($response, '/front/Q&A/sellerQuestionCategorys.phtml', compact('categorys'));
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function question(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $question = $this->questionService->findById($args['id']);

        return $this->view->render($response, '/front/Q&A/question.phtml', compact('question'));
    }

    public function success(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        return $this->view->render($response, '/front/common/success.phtml');
    }

    public function paper(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        return $this->view->render($response, '/front/common/paper.phtml');
    }

    public function info(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $title = '纸色嘉年华';
        $info = '活动已结束<br>敬请下一期活动,谢谢您的支持';
        return $this->view->render($response, '/front/common/info.phtml', compact('title', 'info'));
    }

    public function index(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $active = 'index';
        return $this->view->render($response, '/front/pages/index.phtml', compact('active'));
    }

    public function successList(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $active = 'success';
        return $this->view->render($response, '/front/pages/success.phtml', compact('active'));
    }

    public function contact(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $active = 'contact';
        return $this->view->render($response, '/front/pages/contact.phtml', compact('active'));
    }

    public function team(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $active = 'team';
        return $this->view->render($response, '/front/pages/team.phtml', compact('active'));
    }

    public function adIntentionLook(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $active = 'adIntentionLook';
        return $this->view->render($response, '/front/pages/adIntention.phtml', compact('active'));
    }

    public function deviceInfo(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $active = 'deviceInfo';
        return $this->view->render($response, '/front/pages/deviceInfo.phtml', compact('active'));
    }

    public function jobInfo(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $active = 'jobInfo';
        return $this->view->render($response, '/front/pages/jobInfo.phtml', compact('active'));
    }

    public function tipOffFeedback(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $active = 'tipOffFeedback';
        return $this->view->render($response, '/front/Q&A/tipOffFeedback.phtml', compact('active'));
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     * @throws \Exception
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function upWorks(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {

        if (!DateHelper::isEarly(date('Y-m-d H:i:s'), '2018-08-08 23:59:59')) {
            $title = '纸色嘉年华';
            $info = '活动已结束<br>敬请下一期活动,谢谢您的支持';
            return $this->view->render($response, '/front/common/info.phtml', compact('title', 'info'));
        }

        $wxOpenId = null;
        if ($wxUser = $this->session->get(SessionConstant::WECHAT_USER)) {
            $wxOpenId = $wxUser['id'];
        }

        ValidationHelper::checkIsNull($wxOpenId, 'wxOpenId');

        $em = $this->container->get(EntityManager::class);

        $workService = new WorkService($em);

        $work = $workService->findByWxOpenId($wxOpenId);

        /** @var Response $response */
        if ($work) return $response->withRedirect('/activity/myWorks?id=' . $work->id);

        $jsSdk = $this->app->jssdk;

        return $this->view->render($response, '/front/activity/upWorks.phtml', compact('jsSdk'));
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     * @throws \Exception
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function submitWorks(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        /** @var Request $request */
        $id = $request->getParam('id');

        ValidationHelper::checkIsNull($id, 'id');

        $em = $this->container->get(EntityManager::class);

        $workService = new WorkService($em);
        $workImageService = new WorkImageService($em);

        $work = $workService->findById($id);
        $workImage = $workImageService->findByWorkNo($id);

        ValidationHelper::checkIsTrue($work, 'work can not be found!');
        ValidationHelper::checkIsTrue($workImage, 'workImage can not be found!');

        if (!$workService->isHandle($work)) {
            $title = '上传成功';
            $error = '感谢您的支持,待作品审核通过会展示于此页面';
            return $this->view->render($response, '/front/common/error.phtml', compact('error', 'title'));
        }

        $jsSdk = $this->app->jssdk;

        return $this->view->render($response, '/front/activity/submitWorks.phtml', compact('work', 'workImage', 'jsSdk'));
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     * @throws \Exception
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function myWorks(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $wxOpenId = null;
        if ($wxUser = $this->session->get(SessionConstant::WECHAT_USER)) {
            $wxOpenId = $wxUser['id'];
        }

        /** @var Request $request */
        $id = $request->getParam('id');

        ValidationHelper::checkIsNull($wxOpenId, 'wxOpenId');
        ValidationHelper::checkIsNull($id, 'id');

        $em = $this->container->get(EntityManager::class);
        $voteService = new VoteService($em);
        $workService = new WorkService($em);
        $workImageService = new WorkImageService($em);

        $this->logger->addInfo(FrontViewController::class, (array)$wxOpenId);

        $vote = $voteService->findByWxOpenId($wxOpenId);

        if ($vote) {
            $voteFlag = false;
        } else {
            $voteFlag = true;
        }

        $this->logger->addInfo(FrontViewController::class, (array)$voteFlag);

        $myWork = $workService->findById($id);
        $myWorkImage = $workImageService->findByWorkNo($id);

        ValidationHelper::checkIsTrue($myWork, 'my work can not be found!');
        ValidationHelper::checkIsTrue($myWorkImage, 'my workImage can not be found!');

        if (!$workService->isHandle($myWork)) {
            $title = '上传成功';
            $error = '感谢您的支持,待作品审核通过会展示于此页面';
            return $this->view->render($response, '/front/common/error.phtml', compact('error', 'title'));
        }

        //排行榜
        $chartsService = new ChartsService($em);

        $top = $chartsService->getTop100();

        $this->logger->addInfo(FrontViewController::class, (array)$top);

        $myWorkVote = null;

        $resultTop = [];
        foreach ($top as $position => $topItem) {
            $id = $topItem['workNo'];
            $voteNum = $topItem['voteNum'];

            $position = $position + 1;

            if ($id == $myWork->id) {
                $myWorkVote = WorkVote::convertByWorkAndWorkImageAndVote($myWork, $myWorkImage, $position, $voteNum);
            }

            $work = $workService->findById($id);
            $workImage = $workImageService->findByWorkNo($id);
            $workVote = WorkVote::convertByWorkAndWorkImageAndVote($work, $workImage, $position, $voteNum);

            $this->logger->addInfo(FrontViewController::class, (array)$workVote);
            $resultTop[] = $workVote;
        }

        $this->logger->addInfo(FrontViewController::class, (array)$myWorkVote);
        $this->logger->addInfo(FrontViewController::class, (array)$resultTop);

        $jsSdk = $this->app->jssdk;

        $activity = true;
        if (!DateHelper::isEarly(date('Y-m-d H:i:s'), '2018-08-08 23:59:59')) {
            $activity = false;
        }
        return $this->view->render($response, '/front/activity/myWorks.phtml', compact('myWorkVote', 'resultTop', 'voteFlag', 'jsSdk', 'activity'));
    }


}