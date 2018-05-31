<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/24/18
 * Time: 11:41 AM
 */

namespace Cms\Entity;
use Cms\Entity\ex\BaseProperty;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserFeedBack
 * @package Cms\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="user_feedback")
 */
class UserFeedBack
{
    use BaseProperty;

    /**
     * @var string
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
     * @ORM\Column(type="string",columnDefinition="ENUM('freeError','paymentError','codeError','machineError')")
     */
    public $qType;
    /**
     * @var string
     *
     * @ORM\Column(type="string",nullable=true)
     */
    public $qDescription;
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    public $wxId;
    /**
     * @var string
     *
     * @ORM\Column(name="machine_code",type="string")
     */
    public $machineCode;
    /**
     * @var string
     *
     * @ORM\Column(type="string",nullable=true)
     */
    public $addition;
    /**
     * @var string
     *
     * @ORM\Column(name="addition_type",type="string",columnDefinition="ENUM('picture')",nullable=true)
     */
    public $additionType;

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
    public function getAddition()
    {
        return $this->addition;
    }

    /**
     * @param string $addition
     */
    public function setAddition($addition)
    {
        $this->addition = $addition;
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

}