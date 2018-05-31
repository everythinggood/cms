<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/24/18
 * Time: 12:35 PM
 */

namespace Cms\Entity;


use Cms\Entity\ex\BaseProperty;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class AdIntention
 * @package Cms\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="ad_intention")
 */
class AdIntention
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
     * @ORM\Column(type="string")
     */
    public $address;
    /**
     * @var string
     *
     * @ORM\Column(name="ad_type",type="string",columnDefinition="ENUM('online','offline')")
     */
    public $adType;
    /**
     * @var float
     *
     * @ORM\Column(name="ad_money",type="float",nullable=true)
     */
    public $adMoney;
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    public $intention;

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
    public function getAdType()
    {
        return $this->adType;
    }

    /**
     * @param string $adType
     */
    public function setAdType($adType)
    {
        $this->adType = $adType;
    }

    /**
     * @return float
     */
    public function getAdMoney()
    {
        return $this->adMoney;
    }

    /**
     * @param float $adMoney
     */
    public function setAdMoney($adMoney)
    {
        $this->adMoney = $adMoney;
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

}