<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 8/29/18
 * Time: 5:07 PM
 */

namespace Cms\Service;


use Cms\Entity\TipOffFeedback;
use Doctrine\ORM\EntityManager;

class TipOffFeedbackService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * TipOffFeedbackService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param array $data
     * @return TipOffFeedback
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createTipOff(array $data){
        $tipOff = new TipOffFeedback();
        $tipOff->setCreateTime(new \DateTime());
        $tipOff->setUpdateTime(new \DateTime());
        $tipOff->setCity($data['city']);
        $tipOff->setProvince($data['province']);
        $tipOff->setPhone($data['phone']);
        $tipOff->setWxId($data['wxId']);
        $tipOff->setUserName($data['userName']);
        $tipOff->setMachineCode($data['machineCode']);
        $tipOff->setAdvise($data['advise']?:"");
        $tipOff->setDetail($data['detail']);
        $tipOff->setOtherDetail($data['otherDetail']?:"");
        $tipOff->setPicture($data['picture']);
        $tipOff->setIsHandle(TipOffFeedback::$pending);

        $this->em->persist($tipOff);
        $this->em->flush();

        return $tipOff;
    }

    public function findAll(){
        $tipOffs = $this->em->getRepository(TipOffFeedback::class)->findAll();

        return $tipOffs;
    }

    /**
     * @param $id
     * @return TipOffFeedback|null|object
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function handle($id){
        $tipOff = $this->em->getRepository(TipOffFeedback::class)->find($id);

        $tipOff->setIsHandle(TipOffFeedback::$done);

        $this->em->persist($tipOff);
        $this->em->flush();

        return $tipOff;
    }




















}