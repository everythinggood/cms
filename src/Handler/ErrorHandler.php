<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/25/18
 * Time: 10:04 AM
 */

namespace Cms\Handler;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;

class ErrorHandler
{
    public function __invoke(ServerRequestInterface $request,ResponseInterface $response,\Exception $exception)
    {
        /** @var Response $response */
        return $response->withJson([
            'exception'=>$exception->getMessage(),
            'code'=>$exception->getCode()
        ],500);
    }

}