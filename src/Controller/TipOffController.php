<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 8/29/18
 * Time: 4:39 PM
 */

namespace Cms\Controller;


use Cms\Helper\FileHelper;
use Cms\Helper\MatchHelper;
use Cms\Helper\ValidationHelper;
use Cms\Service\TipOffFeedbackService;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;

class TipOffController
{

    /**
     * @var Container
     */
    private $container;
    /**
     * @var Logger
     */
    private $logger;
    /**
     * @var string
     */
    private $uploadDirectory;

    /**
     * UserController constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->logger = $container["logger"];
        $this->uploadDirectory = $container['settings']['upload_file_directory'];
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface|Response
     * @throws \Exception
     */
    public function add(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {

        /** @var Request $request */

        $userName = $request->getParam('userName');
        $phone = $request->getParam('phone');
        $wxId = $request->getParam('wxId');
        $province = $request->getParam('province');
        $city = $request->getParam('city');
        $detail = $request->getParam('detail');
        $otherDetail = $request->getParam('otherDetail');
        $machineCode = $request->getParam('machineCode');
        $advise = $request->getParam('advise');
        $uploadedFiles = $request->getUploadedFiles();
        $multipleFiles = [];
        /** @var UploadedFile $uploadedFile */
        $uploadedMultipleFiles = $uploadedFiles['multipleFiles'];
        /** @var UploadedFile $uploadedFile */
        foreach ($uploadedMultipleFiles as $uploadedFile){
            if ($uploadedFile && $uploadedFile->getError() === UPLOAD_ERR_OK) {
                $filename = FileHelper::moveUploadedFile($this->uploadDirectory, $uploadedFile);
                $multipleFiles[] = $filename;
            }
        }

        ValidationHelper::checkIsNull($userName, 'uerName');
        ValidationHelper::checkIsNull($phone, 'phone');
        ValidationHelper::checkIsNull($wxId, 'wxId');
        ValidationHelper::checkIsNull($province, 'province');
        ValidationHelper::checkIsNull($city, 'city');
        ValidationHelper::checkIsNull($detail, 'detail');
        ValidationHelper::checkIsNull($machineCode, 'machineCode');
        ValidationHelper::checkIsTrue($multipleFiles, 'picture');

        ValidationHelper::checkIsTrue(MatchHelper::isPhone($phone),'非法手机号码');

        if(strlen($machineCode) != 16){
            throw new \Exception("非法机器唯一码，应为16位");
        }

        $picture = json_encode($multipleFiles);

        $tipOffService = new TipOffFeedbackService($this->container[EntityManager::class]);
        $tipOff = $tipOffService->createTipOff(compact('userName', 'phone', 'wxId', 'province', 'city', 'detail', 'otherDetail', 'machineCode', 'advise', 'picture'));

        /** @var Response $response */
        return $response->withJson([
            'data' => $tipOff
        ]);
    }

    public function findAll(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {


        $tipOffService = new TipOffFeedbackService($this->container[EntityManager::class]);
        $tipOffs = $tipOffService->findAll();

        /** @var Response $response */
        return $response->withJson([
            'data' => $tipOffs
        ]);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function handle(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        /** @var Request $request */
        $id = $request->getParam('id');

        ValidationHelper::checkIsNull($id, 'id');

        $tipOffService = new TipOffFeedbackService($this->container[EntityManager::class]);
        $tipOff = $tipOffService->handle($id);

        /** @var Response $response */
        return $response->withJson([
            'data' => $tipOff
        ]);
    }

}