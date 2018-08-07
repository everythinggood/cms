<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 8/7/18
 * Time: 10:58 AM
 */

namespace Cms\Controller;


use Intervention\Image\ImageManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Slim\Container;
use Slim\Http\Response;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;

class ImageController
{
    /**
     * @var string
     */
    private $uploadDirectory;
    /**
     * @var Container
     */
    private $container;
    /**
     * @var ImageManager
     */
    private $imageManager;

    /**
     * ImageController constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->uploadDirectory = $container['settings']['upload_file_directory'];
        $this->imageManager = $container['imageManager'];
    }

    public function thumb(ServerRequestInterface $request,ResponseInterface $response,array $args){
        $imagePath = $args['path'];

        $responseBody = $this->imageManager->make($this->uploadDirectory.DIRECTORY_SEPARATOR.$imagePath)
            ->heighten(300, function ($constraint) {
                $constraint->upsize();
            })
            ->stream('jpg',50);

        /** @var Response $response */
        $response = $response->withHeader('Content-Type','image/jpg');
        return $response->withBody($responseBody);

    }


}