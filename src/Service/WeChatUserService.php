<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 7/25/18
 * Time: 11:44 AM
 */

namespace Cms\Service;


use Cms\Entity\WeChatUser;
use Cms\Helper\ReplaceHelper;
use Cms\Helper\ValidationHelper;
use Doctrine\ORM\EntityManager;

class WeChatUserService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * WeChatUserService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param array $data
     * @return WeChatUser|null|object
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createWeChatUser(array $data){

        $weChatUser = $this->findByOpenId($data['id']);

        if($weChatUser) return $weChatUser;

        $weChatUser = $this->initWeChatUser($data);

        $this->em->persist($weChatUser);
        $this->em->flush();

        return $weChatUser;

    }

    private function initWeChatUser(array $data){
        $data = $data['original'];
        $nickname = ReplaceHelper::replaceWechatEmoil($data['nickname']);
        $weChatUser = new WeChatUser();
        $weChatUser->setCreateTime(new \DateTime());
        $weChatUser->setUpdateTime(new \DateTime());
        $weChatUser->setCity($data['city']);
        $weChatUser->setCountry($data['country']);
        $weChatUser->setHeadImgUrl($data['headimgurl']);
        $weChatUser->setNickname($nickname);
        $weChatUser->setOpenid($data['openid']);
        $weChatUser->setProvince($data['province']);
        $weChatUser->setSex($data['sex']);
        $weChatUser->setUnionId($data['unionid']?:"");

        return $weChatUser;
    }

    public function findByOpenId($openid){
        return $this->em->getRepository(WeChatUser::class)->findOneBy(['openid'=>$openid]);
    }

    public function findAll()
    {
        return $this->em->getRepository(WeChatUser::class)->findAll();
    }


}