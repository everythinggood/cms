<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/24/18
 * Time: 12:30 PM
 */

namespace Cms\Entity;


use Cms\Entity\ex\BaseProperty;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class SellerIntention
 * @package Cms\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="seller_intention")
 */
class SellerIntention
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
     * @ORM\Column(name="intention_type",type="string",columnDefinition="ENUM('city','person')")
     */
    public $intentionType;
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    public $address;
    /**
     * @var string
     *
     * @ORM\Column(name="addition_type",type="string",nullable=true)
     */
    public $additionType;
    /**
     * @var string
     *
     * @ORM\Column(type="string",nullable=true)
     */
    public $addition;
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    public $intention;
    /**
     * @var string
     *
     * @ORM\Column(type="string",nullable=true)
     */
    public $memo;

    public function toArray(){
        return [
            "userName"=>$this->userName,
            "phone"=>$this->phone,
            "intentionType"=>$this->intentionType,
            "address"=>$this->address,
            "additionType"=>$this->additionType,
            "addition"=>$this->addition,
            "intention"=>$this->intention,
            "memo"=>$this->memo,
        ];
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
    public function getIntentionType()
    {
        return $this->intentionType;
    }

    /**
     * @param string $intentionType
     */
    public function setIntentionType($intentionType)
    {
        $this->intentionType = $intentionType;
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
    public function getIntention()
    {
        return $this->intention;
    }

    /**
     * @param string $intention
     */
    public function setIntention($intention)
    {
        $this->intention = $intention;
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


}