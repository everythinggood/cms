<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 8/29/18
 * Time: 5:01 PM
 */

namespace Cms\Entity;
use Cms\Entity\ex\BaseProperty;
use Doctrine\ORM\Mapping as ORM;


/**
 * Class TipOffFeedback
 * @package Cms\Entity
 * @ORM\Entity
 * @ORM\Table(name="tipoff_feedback")
 */
class TipOffFeedback
{

    use BaseProperty;

    /**
     * @var string
     *
     * @ORM\Column(name="user_name",type="string")
     */
    public $userName;
    /**
     * @var string
     *
     * @ORM\Column(name="phone",type="string")
     */
    public $phone;
    /**
     * @var string
     *
     * @ORM\Column(name="wx_id",type="string")
     */
    public $wxId;
    /**
     * @var string
     *
     * @ORM\Column(name="province",type="string")
     */
    public $province;
    /**
     * @var string
     *
     * @ORM\Column(name="city",type="string")
     */
    public $city;
    /**
     * @var string
     *
     * @ORM\Column(name="machine_code",type="string")
     */
    public $machineCode;
    /**
     * @var string
     *
     * @ORM\Column(name="detail",type="string")
     */
    public $detail;
    /**
     * @var string
     *
     * @ORM\Column(name="other_detail",type="string")
     */
    public $otherDetail;
    /**
     * @var string
     *
     * @ORM\Column(name="advise",type="string")
     */
    public $advise;
    /**
     * @var string
     *
     * @ORM\Column(name="picture",type="string")
     */
    public $picture;

    /**
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param string $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getWxId()
    {
        return $this->wxId;
    }

    /**
     * @param string $wxId
     */
    public function setWxId($wxId)
    {
        $this->wxId = $wxId;
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
    public function getMachineCode()
    {
        return $this->machineCode;
    }

    /**
     * @param string $machineCode
     */
    public function setMachineCode($machineCode)
    {
        $this->machineCode = $machineCode;
    }

    /**
     * @return string
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * @param string $detail
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;
    }

    /**
     * @return string
     */
    public function getOtherDetail()
    {
        return $this->otherDetail;
    }

    /**
     * @param string $otherDetail
     */
    public function setOtherDetail($otherDetail)
    {
        $this->otherDetail = $otherDetail;
    }

    /**
     * @return string
     */
    public function getAdvise()
    {
        return $this->advise;
    }

    /**
     * @param string $advise
     */
    public function setAdvise($advise)
    {
        $this->advise = $advise;
    }

}