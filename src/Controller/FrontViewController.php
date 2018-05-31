<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/29/18
 * Time: 2:55 PM
 */

namespace Cms\Controller;


use Cms\Helper\ValidationHelper;
use Cms\Service\QuestionService;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;

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
     * ViewController constructor.
     * @param Container $container
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->view = $container['renderer'];
        $this->questionService = new QuestionService($container->get(EntityManager::class));
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

        $questions = $this->questionService->findByCategory($category,'seller');

        return $this->view->render($response, '/front/Q&A/sellerQuestions.phtml',compact('questions'));
    }

    public function userQuestions(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {

        $questions = $this->questionService->getUserQuestions();

        return $this->view->render($response, '/front/Q&A/userQuestions.phtml',compact('questions'));
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
        $type = $args['type']?:'seller';

        $topQuestions = $this->questionService->getTopQuestions($type);

        return $this->view->render($response, '/front/Q&A/sellerTopQuestions.phtml',compact('topQuestions'));
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

        return $this->view->render($response, '/front/Q&A/sellerQuestionCategorys.phtml',compact('categorys'));
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

        return $this->view->render($response, '/front/Q&A/question.phtml',compact('question'));
    }

    public function success(ServerRequestInterface $request,ResponseInterface $response,array $args){
        return $this->view->render($response,'/front/common/success.phtml');
    }

}