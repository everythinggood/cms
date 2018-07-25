<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 7/24/18
 * Time: 5:25 PM
 */

namespace Cms\Service;
use Doctrine\ORM\EntityManager;

/**
 * Class ChartsService
 * 排行榜
 * @package Cms\Service
 */
class ChartsService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * ChartsService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return mixed
     */
    public function getTop100(){
        $dql = "select v.workNo ,count(v.wxOpenId) as voteNum from Cms\\Entity\\Work w join Cms\\Entity\\Vote v 
          where w.id = v.workNo group by v.workNo order by voteNum desc";

        return $this->em->createQuery($dql)
            ->setMaxResults(100)
            ->getResult();
    }

}