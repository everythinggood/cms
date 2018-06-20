<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 6/19/18
 * Time: 11:05 AM
 */

namespace Cms\Controller;


use Cms\Entity\Article;
use Cms\Helper\ValidationHelper;
use Cms\Service\ArticleService;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class ArticleController
{
    /**
     * @var Container
     */
    private $container;
    /**
     * @var ArticleService
     */
    private $articleService;

    /**
     * ArticleController constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->articleService = new ArticleService($this->container[EntityManager::class]);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return Response
     * @throws \Exception
     */
    public function add(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        /** @var Request $request */
        /** @var Response $response */
        $type = $request->getParam('type');
        $title = $request->getParam('title');
        $author = $request->getParam('author');
        $content = $request->getParam('content');
        $downloadUrl = $request->getParam('downloadUrl');

        ValidationHelper::checkIsNull($type, 'type');
        ValidationHelper::checkIsNull($title, 'title');
        ValidationHelper::checkIsNull($content, 'content');

        $article = $this->articleService->addArticle(compact('type', 'title', 'author', 'content', 'downloadUrl'));

        ValidationHelper::checkIsTrue($article, 'can not create article');

        return $response->withJson([
            'article' => $article
        ], 200);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return Response
     * @throws \Exception
     */
    public function edit(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        /** @var Request $request */
        /** @var Response $response */
        $id = $request->getParam('id');
        $type = $request->getParam('type');
        $title = $request->getParam('title');
        $author = $request->getParam('author');
        $content = $request->getParam('content');
        $downloadUrl = $request->getParam('downloadUrl');
        $status = $request->getParam('status');

        ValidationHelper::checkIsNull($id, 'id');
        ValidationHelper::checkIsNull($type, 'type');
        ValidationHelper::checkIsNull($title, 'title');
        ValidationHelper::checkIsNull($content, 'content');
        ValidationHelper::checkIsNull($content, 'status');

        $article = $this->articleService->editArticle($id, compact('type', 'status','title', 'author', 'content', 'downloadUrl'));

        ValidationHelper::checkIsTrue($article, 'can not edit article');

        return $response->withJson([
            'article' => $article
        ], 200);

    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return Response
     * @throws \Exception
     */
    public function detail(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $id = $args['id'];
        /** @var Request $request */
        /** @var Response $response */
        $article = $this->articleService->findById($id);

        ValidationHelper::checkIsTrue($article, 'can not found article');

        return $response->withJson([
            'article' => $article
        ], 200);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return Response
     * @throws \Exception
     */
    public function remove(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        /** @var Request $request */
        /** @var Response $response */
        $id = $request->getParam('id');

        ValidationHelper::checkIsNull($id,'id');

        $flag = $this->articleService->deleteById($id);

        return $response->withJson([
            'flag' => $flag
        ], 200);

    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return Response
     * @throws \Exception
     */
    public function details(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        /** @var Request $request */
        /** @var Response $response */
        $type = $request->getParam('type')?:Article::TYPE_ALL;

        ValidationHelper::checkIsNull($type, 'type');
        ValidationHelper::checkIsInArr($type, array_keys(Article::$types), 'type is not vail');

        $articles = $this->articleService->findByType($type);

        return $response->withJson([
            'data'=>(array)$articles
        ], 200);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return Response
     * @throws \Exception
     */
    public function tops(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        /** @var Request $request */
        /** @var Response $response */
        $type = $request->getParam('type');

        ValidationHelper::checkIsNull($type, 'type');
        ValidationHelper::checkIsInArr($type, array_keys(Article::$types), 'type is not vail');

        $articles = $this->articleService->findTopArticles($type);

        return $response->withJson([
            'articles' => $articles
        ], 200);

    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return Response
     * @throws \Exception
     */
    public function pushTop(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        /** @var Request $request */
        /** @var Response $response */
        $id = $args['id'];

        $article = $this->articleService->pushTop($id);

        return $response->withJson([
            'article' => $article
        ], 200);
    }


}