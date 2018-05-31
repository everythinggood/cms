<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/24/18
 * Time: 11:43 AM
 */

namespace Cms\Entity\ex;


use Doctrine\ORM\Mapping as ORM;

trait Base
{

    /**
     * @var integer
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    public $id;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_time",type="datetime")
     */
    public $createTime;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_time",type="datetime")
     */
    public $updateTime;

    /**
     * @return \DateTime
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * @param \DateTime $createTime
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;
    }

    /**
     * @return \DateTime
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * @param \DateTime $updateTime
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;
    }


}