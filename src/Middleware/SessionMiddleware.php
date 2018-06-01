<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 6/1/18
 * Time: 9:33 AM
 */

namespace Cms\Middleware;


use Cms\Service\UserService;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Slim\Http\Response;
use SlimSession\Helper;

class SessionMiddleware
{
    /**
     * @var Helper
     */
    private $session;
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var Logger
     */
    private $logger;

    public function __construct(Helper $session,UserService $userService,Logger $logger)
    {
        $this->session = $session;
        $this->userService = $userService;
        $this->logger = $logger;
    }

    public function __invoke($request, $response, $next)
    {
        /** @var Response $response */
        if(!$this->session->exists('admin_user')){

            return $response->withRedirect('/view/login');
        }

        /**
         * userId:userName
         */
        $adminUser = $this->session->get('admin_user');
        $adminRole = $this->session->get('admin_user_role');

        $this->logger->addInfo('user Session:',compact('adminUser','adminRole'));

        list($userId,$userName) = explode(':',$adminUser);

        $user = $this->userService->findByIdAndUserName($userId,$userName);

        if($user && $adminRole == 'admin'){
            return $next($request,$response);
        }

        return $response->withRedirect('/view/login');
    }


}