<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 7/24/18
 * Time: 11:09 AM
 */

namespace Cms\Controller;


use Cms\Constant\SessionConstant;
use Cms\Helper\FileHelper;
use Cms\Helper\MatchHelper;
use Cms\Helper\ValidationHelper;
use Cms\Service\VoteService;
use Cms\Service\WorkImageService;
use Cms\Service\WorkService;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;
use SlimSession\Helper;

class WorkController
{
    /**
     * @var Container
     */
    private $container;
    /**
     * @var Logger
     */
    private $logger;
    private $uploadDirectory;
    /**
     * @var Helper
     */
    private $session;

    /**
     * WorkController constructor.
     * @param Container $container
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->logger = $container['logger'];
        $this->uploadDirectory = $container['settings']['upload_file_directory'];
        $this->session = $container['session'];
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return Response
     * @throws \Exception
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function add(ServerRequestInterface $request, ResponseInterface $response, array $args){
        $wxOpenId = null;
        if($wxUser = $this->session->get(SessionConstant::WECHAT_USER)){
            $wxOpenId = $wxUser['id'];
        }

        /** @var Request $request */
        $author = $request->getParam('author');
        $city = $request->getParam('city');
        $phone = $request->getParam('phone');
        $weixin = $request->getParam('weixin');
        $name = $request->getParam('worksName');
        $description = $request->getParam('worksDescription');
        $uploadedFiles = $request->getUploadedFiles();
        $singeFile = null;
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $uploadedFiles['singeFile'];
        if ($uploadedFile && $uploadedFile->getError() === UPLOAD_ERR_OK) {
            $filename = FileHelper::moveUploadedFile($this->uploadDirectory, $uploadedFile);
            $singeFile = $filename;
        }

        ValidationHelper::checkIsNull($wxOpenId,'wxOpenId');
        ValidationHelper::checkIsNull($author,'author');
        ValidationHelper::checkIsNull($city,'city');
        ValidationHelper::checkIsNull($phone,'phone');
        ValidationHelper::checkIsNull($weixin,'weixin');
        ValidationHelper::checkIsNull($name,'name');
        ValidationHelper::checkIsNull($description,'description');
        ValidationHelper::checkIsNull($singeFile,'singeFile');

        ValidationHelper::checkIsTrue(MatchHelper::isPhone($phone),'phone is vail!');


        /** @var EntityManager $em */
        $em = $this->container->get(EntityManager::class);

        $workService = new WorkService($em);
        $workImageService = new WorkImageService($em);
        $voteService = new VoteService($em);

        $work = $workService->createWork(compact('author','city','phone','weixin','name','description','wxOpenId'));
        $workImages = $workImageService->createWorkImages($work->id,compact('singeFile'));

        ValidationHelper::checkIsTrue($work,'work is null');
        ValidationHelper::checkIsTrue($workImages,'workImages is null');

        $vote = $voteService->createVoteNoLimit($work->id,$wxOpenId);

        /** @var Response $response */
        return $response->withJson([
            'work'=>$work,
            'workImages'=>$workImages,
            'vote'=>$vote
        ]);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @throws \Exception
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function find(ServerRequestInterface $request, ResponseInterface $response, array $args){


    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return Response
     * @throws \Exception
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function handle(ServerRequestInterface $request, ResponseInterface $response, array $args){
        /** @var Request $request */
        $id = $request->getParam('id');
        $isHandle = $request->getParam('isHandle');

        ValidationHelper::checkIsNull($id,'id');
        ValidationHelper::checkIsNull($isHandle,'isHandle');

        if(!in_array($isHandle,['pending','done'])) throw new \Exception('isHandle is vail!');

        /** @var EntityManager $em */
        $em = $this->container->get(EntityManager::class);

        $workService = new WorkService($em);

        $isHandle = $workService->handle($id,$isHandle);

        /** @var Response $response */
        return $response->withJson([
            'isHandle'=>$isHandle
        ]);
    }


}