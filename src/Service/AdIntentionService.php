<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/24/18
 * Time: 4:19 PM
 */

namespace Cms\Service;


use Cms\Entity\AdIntention;
use Doctrine\ORM\EntityManager;

class AdIntentionService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * AdIntentionService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param array $data
     * @return AdIntention
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createAdIntention(array $data){
        $adIntention = new AdIntention();
        $adIntention->setUpdateTime(new \DateTime());
        $adIntention->setCreateTime(new \DateTime());
        $adIntention->setAddress($data['address']);
        $adIntention->setPhone($data['phone']);
        $adIntention->setUserName($data['userName']);
        $adIntention->setAdMoney($data['adMoney']);
        $adIntention->setAdType($data['adType']);
        $adIntention->setIsHandle($data['isHandle']?:'pending');
        $adIntention->setIntention($data['intention']);

        $this->em->persist($adIntention);
        $this->em->flush();

        return $adIntention;
    }

    public function findAll(){
        $adIntentions = $this->em->getRepository(AdIntention::class)->findAll();

        return $adIntentions;
    }


}