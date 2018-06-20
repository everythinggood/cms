<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/24/18
 * Time: 4:26 PM
 */

namespace Cms\Service;


use Cms\Entity\SellerIntention;
use Cms\Helper\ValidationHelper;
use Doctrine\ORM\EntityManager;

class SellerIntentionService
{

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * SellerIntentionService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param array $data
     * @return SellerIntention
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createSellerIntention(array $data)
    {
        $sellerIntention = new SellerIntention();
        $sellerIntention->setUpdateTime(new \DateTime());
        $sellerIntention->setCreateTime(new \DateTime());
        $sellerIntention->setUserName($data['userName']);
        $sellerIntention->setPhone($data['phone']);
        $sellerIntention->setAddress($data['address']);
        $sellerIntention->setAddition($data['addition'] ?: null);
        $sellerIntention->setAdditionType($data['additionType'] ?: null);
        $sellerIntention->setIntention($data['intention']);
        $sellerIntention->setIntentionType($data['intentionType']);
        $sellerIntention->setMemo($data['memo'] ?: null);
        $sellerIntention->setIsHandle($data['isHandle'] ?: 'pending');

        $this->em->persist($sellerIntention);
        $this->em->flush();

        return $sellerIntention;
    }

    public function findAll()
    {
        $sellerIntentions = $this->em->getRepository(SellerIntention::class)->findAll();

        return $sellerIntentions;
    }

    /**
     * @param $id
     * @return SellerIntention|null|object
     * @throws \Exception
     */
    public function handle($id)
    {
        $sellerIntention = $this->em->getRepository(SellerIntention::class)->find($id);

        ValidationHelper::checkIsTrue($sellerIntention, 'can not found sellerIntention');

        $sellerIntention->setIsHandle(SellerIntention::$done);

        $this->em->persist($sellerIntention);
        $this->em->flush();

        return $sellerIntention;

    }


}