<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 7/25/18
 * Time: 11:39 AM
 */

namespace Cms\Entity;
use Cms\Entity\ex\Base;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class WeChatUser
 * @package Cms\Entity
 * @ORM\Entity
 * @ORM\Table(name="wechat_user")
 */
class WeChatUser
{
    use Base;
    /**
     * @var string
     * @ORM\Column(name="openid",type="string")
     */
    public $openid;
    /**
     * @var string
     * @ORM\Column(name="nickname",type="string")
     */
    public $nickname;
    /**
     * @var string
     * @ORM\Column(name="sex",type="string")
     */
    public $sex;
    /**
     * @var string
     * @ORM\Column(name="province",type="string")
     */
    public $province;
    /**
     * @var string
     * @ORM\Column(name="city",type="string")
     */
    public $city;
    /**
     * @var string
     * @ORM\Column(name="country",type="string")
     */
    public $country;
    /**
     * @var string
     * @ORM\Column(name="head_img_url",type="string")
     */
    public $headImgUrl;
    /**
     * @var string
     * @ORM\Column(name="union_id",type="string")
     */
    public $unionId;

    /**
     * @return string
     */
    public function getOpenid()
    {
        return $this->openid;
    }

    /**
     * @param string $openid
     */
    public function setOpenid($openid)
    {
        $this->openid = $openid;
    }

    /**
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }

    /**
     * @return string
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param string $sex
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
    }

    /**
     * @return string
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param string $province
     */
    public function setProvince($province)
    {
        $this->province = $province;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getHeadImgUrl()
    {
        return $this->headImgUrl;
    }

    /**
     * @param string $headImgUrl
     */
    public function setHeadImgUrl($headImgUrl)
    {
        $this->headImgUrl = $headImgUrl;
    }

    /**
     * @return string
     */
    public function getUnionId()
    {
        return $this->unionId;
    }

    /**
     * @param string $unionId
     */
    public function setUnionId($unionId)
    {
        $this->unionId = $unionId;
    }



}