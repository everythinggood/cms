<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 6/19/18
 * Time: 11:34 AM
 */

namespace Cms\Controller;


use Cms\Entity\MetaData;
use Cms\Helper\FileHelper;
use Cms\Helper\ValidationHelper;
use Cms\Service\MetaDataService;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;
use Slim\Router;

class MetaDataController
{
    /**
     * @var Container
     */
    private $container;
    /**
     * @var MetaDataService
     */
    private $metaDataService;
    /**
     * @var string
     */
    private $uploadDirectory;

    /**
     * MetaDataController constructor.
     * @param Container $container
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->metaDataService = new MetaDataService($this->container[EntityManager::class]);
        $this->uploadDirectory = $container->get('settings')['upload_file_directory'];
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
    public function add(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        /** @var Request $request */
        /** @var Response $response */
        $type = $request->getParam('type');
        $uploadedFiles = $request->getUploadedFiles();

        ValidationHelper::checkIsNull($type, 'type');
        ValidationHelper::checkIsTrue($uploadedFiles, 'must upload some thing');
        ValidationHelper::checkIsInArr($type, array_keys(MetaData::$types), 'type is not vail!');

        $responseData = $this->moveUploadedFilesResponse($uploadedFiles);

        $metaData = null;
        $metaDataArr = null;
        if ($responseData['singeFile']) $metaData = $this->metaDataService->addMetaData(['type' => $type, 'downloadUrl' => $responseData['singeFile']]);
        if (count($responseData['multipleFiles']) > 0) $metaDataArr = $this->metaDataService->addMultipleMetaData($responseData['multipleFiles'], $type);

        return $response->withJson([
            'responseData' => $responseData,
            'metaData' => $metaData,
            'metaDataArr' => $metaDataArr
        ], 200);
    }

    private function moveUploadedFilesResponse(array $uploadedFiles)
    {
        $responseData = [];

        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $uploadedFiles['singeFile'];
        if ($uploadedFile && $uploadedFile->getError() === UPLOAD_ERR_OK) {
            $filename = FileHelper::moveUploadedFile($this->uploadDirectory, $uploadedFile);
            $responseData['singeFile'] = $filename;
        }

        foreach ($uploadedFiles['multipleFiles'] as $uploadedFile) {
            $filename = FileHelper::moveUploadedFile($this->uploadDirectory, $uploadedFile);
            $responseData['multipleFiles'][] = $filename;
        }

        return $responseData;
    }

    public function find(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $id = $args['id'];
        /** @var Request $request */
        /** @var Response $response */
        $metaData = $this->metaDataService->findById($id);

        return $response->withJson([
            'metaData' => $metaData
        ], 200);
    }

    /**
     * not support multiple uploadedFile edit
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return Response
     * @throws \Exception
     */
    public function edit(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $id = $args['id'];
        /** @var Request $request */
        /** @var Response $response */
        $type = $request->getParam('type');
        $uploadedFiles = $request->getUploadedFiles();

        ValidationHelper::checkIsNull($type, 'type');
        ValidationHelper::checkIsTrue($uploadedFiles, 'must upload some thing');

        $responseData = $this->moveUploadedFilesResponse($uploadedFiles);

        $metaData = null;
        if ($responseData['singeFile']) $metaData = $this->metaDataService->editMetaData($id, ['type' => $type, 'downloadUrl' => $responseData['singeFile']]);

        return $response->withJson([
            'responseData' => $responseData,
            'metaData' => $metaData
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

        ValidationHelper::checkIsNull($id, 'id');

        $metaData = $this->metaDataService->deleteById($id);

        ValidationHelper::checkIsTrue($metaData, 'can not remove metaData');

        return $response->withJson([
            'metaData' => $metaData
        ], 200);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return Response
     * @throws \Exception
     */
    public function getMetaDataArr(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {

        /** @var Request $request */
        /** @var Response $response */
        $type = $request->getParam('type') ?: MetaData::TYPE_ALL;

        ValidationHelper::checkIsNull($type, 'type');
        ValidationHelper::checkIsInArr($type, array_keys(MetaData::$types), 'type is not vail');

        $metaDataArr = $this->metaDataService->findByType($type);

        return $response->withJson([
            'metaDataArr' => $metaDataArr
        ], 200);
    }

    public function metadataList(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $metadataList = $this->metaDataService->findAll();
        /** @var Response $response */
        return $response->withJson(['data' => $metadataList], 200);
    }

    /**
     *
     * forala editor upload api
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return static
     * @throws \Exception
     */
    public function upload(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        /** @var Request $request */
        /** @var Response $response */
        $type = $request->getParam('type');
        $uploadedFiles = $request->getUploadedFiles();

        ValidationHelper::checkIsNull($type, 'type');
        ValidationHelper::checkIsTrue($uploadedFiles, 'must upload some thing');

        $responseData = $this->moveUploadedFilesResponse($uploadedFiles);

        $metaData = null;
        if ($responseData['singeFile']) $metaData = $this->metaDataService->addMetaData(['type' => $type, 'downloadUrl' => $responseData['singeFile']]);

        return $response->withJson(['link'=>"/uploads/".$responseData['singeFile']], 200);
    }
}