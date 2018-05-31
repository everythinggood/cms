<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/24/18
 * Time: 6:26 PM
 */

namespace Cms\Controller;


use Cms\Helper\ValidationHelper;
use Cms\Service\QuestionService;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Container;
use Slim\Flash\Messages;
use Slim\Http\Request;
use Slim\Http\Response;

class QuestionController
{
    /**
     * @var Container
     */
    private $container;
    /**
     * @var QuestionService
     */
    private $questionService;

    /**
     * UserController constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->questionService = $container[EntityManager::class];
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return Response
     * @throws \Exception
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function add(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        /** @var Request $request */
        $id = $request->getParam('id');
        $question = $request->getParam('question');
        $category = $request->getParam('category');
        $tags = $request->getParam('tags');
        $answer = $request->getParam('answer');
        $type = $request->getParam('type');
        $weight = $request->getParam('weight');
        /** @var Logger $logger */
        $logger = $this->container->get('logger');
        $logger->addInfo('request body: ', $request->getParams());

        ValidationHelper::checkIsNull($question, 'question');
        ValidationHelper::checkIsNull($category, 'category');
        ValidationHelper::checkIsNull($answer, 'answer');
        ValidationHelper::checkIsNull($type, 'type');

        $questionService = new QuestionService($this->container->get(EntityManager::class));

        if (!$id) {
            $question = $questionService->createQuestion(compact('question', 'category', 'tags', 'answer', 'type','weight'));
            ValidationHelper::checkIsTrue($question, 'create Question fail!');
        }

        if ($id) {
            $question = $questionService->updateQuestionById(compact('question', 'category', 'tags', 'answer', 'type', 'id','weight'));
            ValidationHelper::checkIsTrue($question, "update Question[id=$id] fail!");
        }

        /** @var Response $response */
        return $response->withJson([
            'question' => (array)$question
        ], 200);

    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return Response
     * @throws \Exception
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function getAllByPage(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        /** @var Request $request */
        $page = $request->getParam('page') ?: 1;
        $itemPerPage = $request->getParam('itemPerPage') ?: 30;

        ValidationHelper::checkIsNull($page, 'page');
        ValidationHelper::checkIsNull($itemPerPage, 'itemPerPage');

        $questionService = new QuestionService($this->container->get(EntityManager::class));

        $pagination = $questionService->findAllByPage($page, $itemPerPage);

        /** @var Response $response */
        return $response->withJson(
            (array)$pagination
            , 200);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return Response
     * @throws \Exception
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function delete(ServerRequestInterface $request, ResponseInterface $response, array  $args){
        /** @var Request $request */
        $id = $request->getParam('id');

        ValidationHelper::checkIsNull($id,'id');

        $questionService = new QuestionService($this->container->get(EntityManager::class));

        $flag = $questionService->deleteById($id);

        /** @var Response $response */
        return $response->withJson([
            'deleted'=>$flag
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
    public function pushTop(ServerRequestInterface $request, ResponseInterface $response, array $args){

        /** @var Request $request */
        $id = $request->getParam('id');

        $questionService = new QuestionService($this->container->get(EntityManager::class));

        $flag = $questionService->pushTop($id);

        /** @var Response $response */
        return $response->withJson([
            'pushTop'=>$flag
        ],200);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return Response
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function getCategorys(ServerRequestInterface $request, ResponseInterface $response, array  $args){

        $questionService = new QuestionService($this->container->get(EntityManager::class));

        $cateGorys = $questionService->getCategorys();

        /** @var Response $response */

        return $response->withJson([
            'categorys'=>$cateGorys
        ],200);
    }

    public function getTopQuestions(ServerRequestInterface $request,ResponseInterface $response,array $args){

        $topQuestions = $this->questionService->getTopQuestions();

        /** @var Response $response */
        return $response->withJson([
            (array)$topQuestions
        ],200);

    }


}