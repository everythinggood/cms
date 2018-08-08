<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 8/8/18
 * Time: 9:07 AM
 */

namespace Cms\ShellController;


use Cms\Entity\Vote;
use Cms\Helper\ValidationHelper;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class VoteController
{
    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var Container
     */
    private $container;

    /**
     * VoteController constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->em = $container[EntityManager::class];
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return Response
     * @throws \Exception
     */
    public function multiAdd(ServerRequestInterface $request, ResponseInterface $response, array $args){
        /** @var Request $request */
        $token = $request->getParam('token');
        $id = $request->getParam('id');
        $num = $request->getParam('num');

        ValidationHelper::checkIsNull($token,'token');
        ValidationHelper::checkIsNull($id,'id');
        ValidationHelper::checkIsNull($num,'num');

        //1daedd00ab62d74399e3de1ed27fbd23
        if($token != md5('zhise123')){
            throw new \Exception('token is not vail!');
        }

        while($num > 0){
            $vote = $this->initVote($id,'wx_addition');
            $this->em->persist($vote);
            $num --;
        }
        $this->em->flush();

        /** @var Response $response */
        return $response->withJson([
           'update'=>true
        ]);

    }

    private function initVote($workNo,$wxOpenId){
        $vote = new Vote();
        $vote->setCreateTime(new \DateTime());
        $vote->setUpdateTime(new \DateTime());
        $vote->setWorkNo($workNo);
        $vote->setWxOpenId($wxOpenId);
        return $vote;
    }


}