<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/24/18
 * Time: 5:13 PM
 */

namespace Cms\Controller;


use Cms\Helper\ValidationHelper;
use Cms\Service\UserService;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;
use Slim\Views\PhpRenderer;
use SlimSession\Helper;

class UserController
{
    /**
     * @var Container
     */
    private $container;

    /**
     * UserController constructor.
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
     * @return ResponseInterface
     * @throws \Exception
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function login(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        /** @var Request $request */
        $userName = $request->getParam('userName');
        $password = $request->getParam('password');

        ValidationHelper::checkIsNull($userName, 'userName');
        ValidationHelper::checkIsNull($password, 'password');

        $em = $this->container->get(EntityManager::class);

        $userService = new UserService($em);

        $user = $userService->findByUserNameAndPassword($userName, $password);

        ValidationHelper::checkIsTrue($user, 'userName or password is fail!');

        /** @var Helper $sessionHelper */
        $sessionHelper = $this->container->get('session');
        $sessionHelper->set('admin_user', join([$user->getId(),$user->getName()],':'));
        $sessionHelper->set('admin_user_role', $user->getRole());

        /** @var Response $response */
        return $response->withRedirect('/view/questions');
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
        $name = $request->getParam('name');
        $password = $request->getParam('password');
        $role = $request->getParam('role');

        ValidationHelper::checkIsNull($name, 'name');
        ValidationHelper::checkIsNull($password, 'password');
        ValidationHelper::checkIsNull($role, 'role');

        $em = $this->container->get(EntityManager::class);

        $userService = new UserService($em);

        $user = $userService->createUser(compact('name', 'password', 'role'));

        ValidationHelper::checkIsTrue($user, 'create user fail!');

        /** @var Response $response */
        return $response->withJson([
            'user' => $user
        ], 200);

    }


}