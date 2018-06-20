<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/25/18
 * Time: 2:33 PM
 */

namespace Cms\Controller;


use Cms\Entity\Navigation;
use Cms\Helper\ValidationHelper;
use Cms\Service\ArticleService;
use Cms\Service\MetaDataService;
use Cms\Service\NavigationService;
use Cms\Service\QuestionService;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
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


    public function login(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {

        return $this->view->render($response, '/admin/login.phtml');
    }

    public function questions(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $header = 'customer_service';
        $asider = 'questions';
        return $this->view->render($response, '/admin/questions.phtml', compact('asider', 'header'));
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     * @throws \Exception
     */
    public function questionEditor(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $header = 'customer_service';
        $asider = 'quetsions';
        /** @var Request $request */
        /** @var Route $route */
        $route = $request->getAttribute('route');
        $id = $route->getArgument('id');

        ValidationHelper::checkIsNull($id, 'id');

        $em = $this->container->get(EntityManager::class);
        $questionService = new QuestionService($em);

        $question = $questionService->findById($id);

        return $this->view->render($response, '/admin/questionEditor.phtml', compact('question', 'asider', 'header'));
    }

    public function questionCreate(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $asider = 'questions';
        $header = 'customer_service';
        return $this->view->render($response, '/admin/questionCreate.phtml', compact('header', 'asider'));
    }

    public function userFeedbacks(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $asider = 'userFeedbacks';
        $header = 'customer_service';
        return $this->view->render($response, '/admin/userFeedbacks.phtml', compact('asider', 'header'));
    }

    public function sellerFeedbacks(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $asider = 'sellerFeedbacks';
        $header = 'customer_service';
        return $this->view->render($response, '/admin/sellerFeedbacks.phtml', compact('asider', 'header'));
    }

    public function adIntentions(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $asider = 'adIntentions';
        $header = 'customer_service';
        return $this->view->render($response, '/admin/adIntentions.phtml', compact('asider', 'header'));
    }

    public function sellerIntentions(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $asider = 'sellerIntentions';
        $header = 'customer_service';
        return $this->view->render($response, '/admin/sellerIntentions.phtml', compact('asider', 'header'));
    }

    public function articles(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $header = 'official_website_service';
        $asider = 'articles';
        return $this->view->render($response, '/admin/articles.phtml', compact('asider', 'header'));
    }

    public function articleCreate(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $header = 'official_website_service';
        $asider = 'articles';
        return $this->view->render($response, '/admin/articleCreate.phtml', compact('asider', 'header'));
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     * @throws \Exception
     */
    public function articleEditor(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $header = 'official_website_service';
        $asider = 'articles';

        /** @var Request $request */
        /** @var Route $route */
        $route = $request->getAttribute('route');
        $id = $route->getArgument('id');

        ValidationHelper::checkIsNull($id, 'id');

        $em = $this->container->get(EntityManager::class);
        $articleService = new ArticleService($em);

        $article = $articleService->findById($id);

        return $this->view->render($response, '/admin/articleEditor.phtml', compact('article', 'asider', 'header'));
    }

    public function navigations(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $header = 'official_website_service';
        $asider = 'navigations';

        return $this->view->render($response, '/admin/navigations.phtml', compact('asider', 'header'));
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function navigationCreate(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $header = 'official_website_service';
        $asider = 'navigations';

        $em = $this->container->get(EntityManager::class);
        $navigationService = new NavigationService($em);

        $navigations = $navigationService->findTopNavigations();
        $topNavigations = [];
        /** @var Navigation $navigation */
        foreach ($navigations as $navigation) {
            $topNavigations[$navigation->id] = $navigation->name;
        }

        /** @var Response $response */
        return $this->view->render($response, '/admin/navigationCreate.phtml', compact('asider', 'header', 'topNavigations'));
    }


    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     * @throws \Exception
     */
    public function navigationEditor(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $header = 'official_website_service';
        $asider = 'navigations';
        $id = $args['id'];

        $em = $this->container->get(EntityManager::class);
        $navigationService = new NavigationService($em);

        $navigations = $navigationService->findTopNavigations();
        $topNavigations = [];
        /** @var Navigation $navigation */
        foreach ($navigations as $navigation) {
            $topNavigations[$navigation->id] = $navigation->name;
        }

        $navigation = $navigationService->findById($id);

        /** @var Response $response */
        return $this->view->render($response, '/admin/navigationEditor.phtml', compact('asider', 'header', 'topNavigations', 'navigation'));

    }

    public function metadatas(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $header = 'official_website_service';
        $asider = 'metadatas';
        return $this->view->render($response, '/admin/metadatas.phtml', compact('header', 'asider'));
    }

    public function metadataCreate(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $header = 'official_website_service';
        $asider = 'metadatas';
        return $this->view->render($response, '/admin/metadataCreate.phtml', compact('header', 'asider'));
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function metadataEditor(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $header = 'official_website_service';
        $asider = 'metadatas';

        $id = $args['id'];

        $em = $this->container->get(EntityManager::class);
        $metadataService = new MetaDataService($em);

        $metadata = $metadataService->findById($id);

        return $this->view->render($response, '/admin/metadataEditor.phtml', compact('header', 'asider', 'metadata'));
    }


}