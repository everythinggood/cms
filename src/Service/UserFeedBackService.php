<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/24/18
 * Time: 3:42 PM
 */

namespace Cms\Service;


use Cms\Entity\UserFeedBack;
use Cms\Helper\ValidationHelper;
use Doctrine\ORM\EntityManager;

class UserFeedBackService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * UserFeedBackService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param array $data
     * @return UserFeedBack
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createUserFeedback(array $data){
        $userFeedback = new UserFeedBack();
        $userFeedback->setAddress($data['address']);
        $userFeedback->setMachineCode($data['machineCode']);
        $userFeedback->setPhone($data['phone']);
        $userFeedback->setQDescription($data['qDescription']);
        $userFeedback->setQType($data['qType']);
        $userFeedback->setUserName($data['userName']);
        $userFeedback->setCreateTime(new \DateTime());
        $userFeedback->setUpdateTime(new \DateTime());
        $userFeedback->setIsHandle($data['isHandle']?:'pending');
        $userFeedback->setWxId($data['wxId']);

        $this->em->persist($userFeedback);
        $this->em->flush();

        return $userFeedback;
    }

    public function findAll(){
        $userFeedbacks = $this->em->getRepository(UserFeedBack::class)->findAll();

        return $userFeedbacks;
    }

    /**
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function handle($id){

        /** @var UserFeedBack $userFeedback */
        $userFeedback = $this->em->getRepository(UserFeedBack::class)->find($id);

        ValidationHelper::checkIsTrue($userFeedback,"can not found by [$id]");

        $userFeedback->setIsHandle(UserFeedBack::$done);

        $this->em->persist($userFeedback);
        $this->em->flush();

        return true;
    }

}