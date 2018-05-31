<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/25/18
 * Time: 2:33 PM
 */

namespace Cms\Controller;


use Cms\Service\QuestionService;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Route;
use Slim\Views\PhpRenderer;

class ViewController
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
     * ViewController constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->view = $container['renderer'];
    }


    public function login(ServerRequestInterface $request,ResponseInterface $response,array $args){

        return $this->view->render($response,'/admin/login.phtml');
    }

    public function questions(ServerRequestInterface $request,ResponseInterface $response,array $args){
        $asider = 'questions';
        return $this->view->render($response,'/admin/questions.phtml',compact('asider'));
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     * @throws \Exception
     */
    public function questionEditor(ServerRequestInterface $request, ResponseInterface $response, array  $args){

        /** @var Request $request */
        /** @var Route $route */
        $route = $request->getAttribute('route');
        $id = $route->getArgument('id');

        $em = $this->container->get(EntityManager::class);
        $questionService = new QuestionService($em);

        $question = $questionService->findById($id);

        return $this->view->render($response,'/admin/questionEditor.phtml',[
           'question'=>$question
        ]);
    }

    public function questionCreate(ServerRequestInterface $request,ResponseInterface $response,array $args){
        return $this->view->render($response,'/admin/questionCreate.phtml');
    }

    public function userFeedbacks(ServerRequestInterface $request,ResponseInterface $response,array $args){
        $asider = 'userFeedbacks';
        return $this->view->render($response,'/admin/userFeedbacks.phtml',compact('asider'));
    }

    public function sellerFeedbacks(ServerRequestInterface $request,ResponseInterface $response,array $args){
        $asider = 'sellerFeedbacks';
        return $this->view->render($response,'/admin/sellerFeedbacks.phtml',compact('asider'));
    }

    public function adIntentions(ServerRequestInterface $request,ResponseInterface $response,array $args){
        $asider = 'adIntentions';
        return $this->view->render($response,'/admin/adIntentions.phtml',compact('asider'));
    }
    public function sellerIntentions(ServerRequestInterface $request,ResponseInterface $response,array $args){
        $asider = 'sellerIntentions';
        return $this->view->render($response,'/admin/sellerIntentions.phtml',compact('asider'));
    }



}