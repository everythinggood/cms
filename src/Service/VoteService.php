<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 7/24/18
 * Time: 11:06 AM
 */

namespace Cms\Service;
use Cms\Entity\Vote;
use Doctrine\ORM\EntityManager;

/**
 * Class VoteService
 * @package Cms\Service
 */
class VoteService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * VoteService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param $workNo
     * @param $wxOpenId
     * @return Vote
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createVote($workNo, $wxOpenId){

        if($vote = $this->findByWxOpenId($wxOpenId)) return null;

        $vote = $this->initVote($workNo,$wxOpenId);

        $this->em->persist($vote);
        $this->em->flush();

        return $vote;
    }

    private function initVote($workNo,$wxOpenId){
        $vote = new Vote();
        $vote->setCreateTime(new \DateTime());
        $vote->setUpdateTime(new \DateTime());
        $vote->setWorkNo($workNo);
        $vote->setWxOpenId($wxOpenId);

        return $vote;
    }

    public function findByWxOpenId($id){
        return $this->em->getRepository(Vote::class)->findOneBy(['wxOpenId'=>$id]);
    }


}