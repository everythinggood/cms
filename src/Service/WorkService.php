<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 7/24/18
 * Time: 10:47 AM
 */

namespace Cms\Service;


use Cms\Entity\Work;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;

class WorkService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * WorkService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param array $data
     * @return Work
     * @throws ORMException
     * @throws \Exception
     */
    public function createWork(array $data)
    {
        $work = $this->findByPhoneOrWeiXin($data['phone'],$data['weixin']);

        if($work) return $work;

        $work = new Work();
        $work->setCreateTime(new \DateTime());
        $work->setUpdateTime(new \DateTime());
        $work->setAuthor($data['author']);
        $work->setPhone($data['phone']);
        $work->setCity($data['city']);
        $work->setWeiXin($data['weixin']);
        $work->setWorkDescription($data['description']);
        $work->setWorkName($data['name']);
        $work->setWxOpenId($data['wxOpenId']);
        $work->setIsHandle(Work::$pending);

        $this->em->persist($work);
        $this->em->flush();

        return $work;
    }

    /**
     * @param $id
     * @return Work|null|object
     */
    public function findById($id)
    {
        return $this->em->getRepository(Work::class)->find($id);
    }

    public function findByPhoneOrWeiXin($phone, $weixin)
    {
        $dql = "select w from Cms\\Entity\\Work w where w.phone = ?1 or w.weiXin = ?2";

        return $this->em->createQuery($dql)
            ->setParameter(1, $phone)
            ->setParameter(2, $weixin)
            ->setMaxResults(1)
            ->getResult();
    }

    public function findByWxOpenId($wxOpenId)
    {
        if($wxOpenId == null) return null;
        return $this->em->getRepository(Work::class)->findOneBy(['wxOpenId'=>$wxOpenId]);
    }

    public function isHandle(Work $work){
        if($work->isHandle == Work::$done) return true;
        return false;
    }

    /**
     * @param $id
     * @param $isHandle
     * @return bool
     * @throws ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function handle($id, $isHandle)
    {
        $work = $this->findById($id);

        if(!$work) return false;

        $work->setIsHandle($isHandle);

        $this->em->persist($work);
        $this->em->flush();

        return true;
    }


}