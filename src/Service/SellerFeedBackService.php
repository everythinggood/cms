<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/24/18
 * Time: 4:14 PM
 */

namespace Cms\Service;


use Cms\Entity\SellerFeedBack;
use Cms\Helper\ValidationHelper;
use Doctrine\ORM\EntityManager;

class SellerFeedBackService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * SellerFeedBackService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param array $data
     * @return SellerFeedBack
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createSellerFeedback(array $data){
        $sellerFeedback = new SellerFeedBack();
        $sellerFeedback->setUserName($data['userName']);
        $sellerFeedback->setQType($data['qType']);
        $sellerFeedback->setQDescription($data['qDescription']);
        $sellerFeedback->setPhone($data['phone']);
        $sellerFeedback->setAddress($data['address']);
        $sellerFeedback->setMemo($data['memo']?:null);
        $sellerFeedback->setQDetail($data['qDetail']?:null);
        $sellerFeedback->setAdditionType($data['additionType']);
        $sellerFeedback->setAddition($data['addition']);
        $sellerFeedback->setCreateTime(new \DateTime());
        $sellerFeedback->setUpdateTime(new \DateTime());
        $sellerFeedback->setIsHandle($data['isHandle']?:'pending');

        $this->em->persist($sellerFeedback);
        $this->em->flush();

        return $sellerFeedback;
    }

    /**
     * @throws \Exception
     */
    public function findAll(){

        $sellerFeedbacks = $this->em->getRepository(SellerFeedBack::class)->findAll();

        return $sellerFeedbacks;
    }

    /**
     * @param $id
     * @return SellerFeedBack
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function handle($id)
    {
        /** @var SellerFeedBack $sellerFeedback */
        $sellerFeedback = $this->em->getRepository(SellerFeedBack::class)->find($id);

        ValidationHelper::checkIsTrue($sellerFeedback,"can not found by [$id]");

        $sellerFeedback->setIsHandle(SellerFeedBack::$done);

        $this->em->persist($sellerFeedback);
        $this->em->flush();

        return $sellerFeedback;

    }


}