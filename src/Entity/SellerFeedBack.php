<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/24/18
 * Time: 12:07 PM
 */

namespace Cms\Entity;
use Cms\Entity\ex\BaseProperty;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class SellerFeedBack
 * @package Cms\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="seller_feedback")
 */
class SellerFeedBack
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
     * @ORM\Column(type="string")
     */
    public $phone;
    /**
     * @var string
     *
     * @ORM\Column(type="string",nullable=true)
     */
    public $address;
    /**
     * @var string
     *
     * @ORM\Column(type="string",columnDefinition="ENUM('machine','software','suggestion')")
     */
    public $qType;
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    public $qDescription;
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    public $qDetail;
    /**
     * @var string
     *
     * @ORM\Column(name="addition_type",type="string",columnDefinition="ENUM('picture')")
     */
    public $additionType;
    /**
     * @var mixed
     *
     * @ORM\Column(type="string",nullable=true)
     */
    public $addition;
    /**
     * @var string
     *
     * @ORM\Column(type="string",nullable=true)
     */
    public $memo;
    /**
     * @var string
     *
     * @ORM\Column(name="is_handle",type="string",options={"default"="pending"},columnDefinition="ENUM('pending','done')")
     */
    public $isHandle;


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
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getQType()
    {
        return $this->qType;
    }

    /**
     * @param string $qType
     */
    public function setQType($qType)
    {
        $this->qType = $qType;
    }

    /**
     * @return string
     */
    public function getQDescription()
    {
        return $this->qDescription;
    }

    /**
     * @param string $qDescription
     */
    public function setQDescription($qDescription)
    {
        $this->qDescription = $qDescription;
    }

    /**
     * @return string
     */
    public function getQDetail()
    {
        return $this->qDetail;
    }

    /**
     * @param string $qDetail
     */
    public function setQDetail($qDetail)
    {
        $this->qDetail = $qDetail;
    }

    /**
     * @return string
     */
    public function getAdditionType()
    {
        return $this->additionType;
    }

    /**
     * @param string $additionType
     */
    public function setAdditionType($additionType)
    {
        $this->additionType = $additionType;
    }

    /**
     * @return mixed
     */
    public function getAddition()
    {
        return $this->addition;
    }

    /**
     * @param mixed $addition
     */
    public function setAddition($addition)
    {
        $this->addition = $addition;
    }

    /**
     * @return string
     */
    public function getMemo()
    {
        return $this->memo;
    }

    /**
     * @param string $memo
     */
    public function setMemo($memo)
    {
        $this->memo = $memo;
    }
}