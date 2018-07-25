<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 7/24/18
 * Time: 10:31 AM
 */

namespace Cms\Entity;
use Cms\Entity\ex\Base;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class work
 * @package Cms\Entity
 * @ORM\Entity
 * @ORM\Table(name="work")
 */
class Work
{
    use Base;

    /**
     * @var string
     * @ORM\Column(name="author",type="string")
     */
    public $author;
    /**
     * @var string
     * @ORM\Column(name="city",type="string")
     */
    public $city;
    /**
     * @var string
     * @ORM\Column(name="phone",type="string")
     */
    public $phone;
    /**
     * @var string
     * @ORM\Column(name="wei_xin",type="string")
     */
    public $weiXin;
    /**
     * @var string
     * @ORM\Column(name="work_name",type="string")
     */
    public $workName;
    /**
     * @var
     * @ORM\Column(name="work_description",type="string")
     */
    public $workDescription;
    /**
     * @var string
     * @ORM\Column(name="wx_open_id",type="string")
     */
    public $wxOpenId;

    /**
     * @return string
     */
    public function getWxOpenId()
    {
        return $this->wxOpenId;
    }

    /**
     * @param string $wxOpenId
     */
    public function setWxOpenId($wxOpenId)
    {
        $this->wxOpenId = $wxOpenId;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
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
    public function getWeiXin()
    {
        return $this->weiXin;
    }

    /**
     * @param string $weiXin
     */
    public function setWeiXin($weiXin)
    {
        $this->weiXin = $weiXin;
    }

    /**
     * @return string
     */
    public function getWorkName()
    {
        return $this->workName;
    }

    /**
     * @param string $workName
     */
    public function setWorkName($workName)
    {
        $this->workName = $workName;
    }

    /**
     * @return mixed
     */
    public function getWorkDescription()
    {
        return $this->workDescription;
    }

    /**
     * @param mixed $workDescription
     */
    public function setWorkDescription($workDescription)
    {
        $this->workDescription = $workDescription;
    }


}