<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 6/19/18
 * Time: 10:02 AM
 */

namespace Cms\Entity;


use Cms\Entity\ex\Base;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Navigation
 * @package Cms\Entity
 * @ORM\Entity
 * @ORM\Table(name="navigation")
 */
class Navigation
{

    public static $zIndexes = [
        '0'=>'0级导航',
        '1'=>'1级导航'
    ];

    use Base;
    /**
     * @var string
     * @ORM\Column(name="name",nullable=false,type="string")
     */
    public $name;
    /**
     * @var int
     * @ORM\Column(name="z_index",nullable=false,type="integer")
     */
    public $zIndex;
    /**
     * @var int
     * @ORM\Column(name="inherit_id",nullable=true,type="integer")
     */
    public $inheritId;
    /**
     * @var string
     * @ORM\Column(name="href",nullable=true,type="string")
     */
    public $href;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getZIndex()
    {
        return $this->zIndex;
    }

    /**
     * @param int $zIndex
     */
    public function setZIndex($zIndex)
    {
        $this->zIndex = $zIndex;
    }

    /**
     * @return int
     */
    public function getInheritId()
    {
        return $this->inheritId;
    }

    /**
     * @param int $inheritId
     */
    public function setInheritId($inheritId)
    {
        $this->inheritId = $inheritId;
    }

    /**
     * @return string
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @param string $href
     */
    public function setHref($href)
    {
        $this->href = $href;
    }

}