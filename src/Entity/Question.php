<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/24/18
 * Time: 12:39 PM
 */

namespace Cms\Entity;
use Cms\Entity\ex\Base;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Question
 * @package Cms\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="question")
 */
class Question
{

    public static $sellerCategorys = [
        'machineInstallError'=>'设备安装问题',
        'machineOrSystemError'=>'设备或纸巾系统问题',
        'paperError'=>'纸巾存储问题',
        'sellerPlatformError'=>'商户平台问题',
        'adError'=>'广告投放问题'
    ];

    public static $userCategorys = [
        'default'=>'默认分类'
    ];

    use Base;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    public $question;
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    public $category;
    /**
     * @var array
     *
     * @ORM\Column(type="simple_array",nullable=true)
     */
    public $tags;
    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    public $answer;
    /**
     * @var string
     *
     * @ORM\Column(type="string",columnDefinition="ENUM('user','seller')")
     */
    public $type;
    /**
     * @var int
     * 权重
     * @ORM\Column(type="integer")
     */
    public $weight = 100;

    /**
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param string $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param string $answer
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
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
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }
}