<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 6/19/18
 * Time: 10:24 AM
 */

namespace Cms\Entity;


use Cms\Entity\ex\Base;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class MetaData
 * @package Cms\Entity
 * @ORM\Entity
 * @ORM\Table(name="metadata")
 */
class MetaData
{

    const TYPE_SWIPER = 'swiper';
    const TYPE_IMAGE = 'image';
    const TYPE_OTHER = 'other';
    const TYPE_SUCCESS = 'success';
    const TYPE_ALL = 'all';

    const STATUS_UP = 'up';
    const STATUS_DOWN = 'down';

    public static $types = [
        self::TYPE_IMAGE=>'图片',
        self::TYPE_OTHER=>'其他',
        self::TYPE_SWIPER=>'轮播图',
        self::TYPE_SUCCESS=>'成功案例图',
        self::TYPE_ALL=>'所有'
    ];

    public static $statues = [
        self::STATUS_UP=>'启用',
        self::STATUS_DOWN=>'停用'
    ];

    use Base;

    /**
     * @var string
     * @ORM\Column(name="type",type="string",columnDefinition="ENUM('swiper','image','other','success')")
     */
    public $type;
    /**
     * @var string
     * @ORM\Column(name="download_url",type="string")
     */
    public $downloadUrl;
    /**
     * @var string
     * @ORM\Column(name="status",type="string",columnDefinition="ENUM('up','down')")
     */
    public $status;

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getDownloadUrl()
    {
        return $this->downloadUrl;
    }

    /**
     * @param string $downloadUrl
     */
    public function setDownloadUrl($downloadUrl)
    {
        $this->downloadUrl = $downloadUrl;
    }

}