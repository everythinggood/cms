<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 7/24/18
 * Time: 10:43 AM
 */

namespace Cms\Entity;
use Cms\Entity\ex\Base;
use Doctrine\ORM\Mapping as ORM;


/**
 * Class Vote
 * @package Cms\Entity
 * @ORM\Entity
 * @ORM\Table(name="vote")
 */
class Vote
{
    use Base;

    /**
     * @var string
     * @ORM\Column(name="wx_open_id",type="string")
     */
    public $wxOpenId;
    /**
     * @var string
     * @ORM\Column(name="work_no",type="string")
     */
    public $workNo;

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
    public function getWorkNo()
    {
        return $this->workNo;
    }

    /**
     * @param string $workNo
     */
    public function setWorkNo($workNo)
    {
        $this->workNo = $workNo;
    }

}