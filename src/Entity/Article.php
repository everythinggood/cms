<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 6/19/18
 * Time: 10:16 AM
 */

namespace Cms\Entity;


use Cms\Entity\ex\Base;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Article
 * @package Cms\Entity
 * @ORM\Entity
 * @ORM\Table(name="article")
 */
class Article
{

    const TYPE_NEWS = 'news';
    const TYPE_NOTICE = 'notice';
    const TYPE_ALL = 'all';

    public static $types = [
        self::TYPE_NEWS=>'新闻',
        self::TYPE_NOTICE=>'公告',
        self::TYPE_ALL=>'全部'
    ];

    const STATUS_TOP = 'top';
    const STATUS_DEFAULT = 'default';

    public static $statues = [
        self::STATUS_DEFAULT=>'默认',
        self::STATUS_TOP=>'置顶'
    ];

    use Base;
    /**
     * @var string
     * @ORM\Column(name="title",type="string")
     */
    public $title;
    /**
     * @var string
     * @ORM\Column(name="author",type="string")
     */
    public $author = '纸色';
    /**
     * @var string
     * @ORM\Column(name="type",columnDefinition="ENUM('news','notice')",nullable=false,type="string")
     */
    public $type;
    /**
     * @var string
     * @ORM\Column(name="content",type="text")
     */
    public $content;
    /**
     * @var string
     * @ORM\Column(name="download_url",type="string",nullable=true)
     */
    public $downloadUrl;
    /**
     * @var string
     * @ORM\Column(name="status",type="string",columnDefinition="ENUM('top','default')")
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
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