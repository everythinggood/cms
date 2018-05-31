<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/24/18
 * Time: 12:45 PM
 */

namespace Cms\Entity;
use Cms\Entity\ex\Base;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Tag
 * @package Cms\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="tag")
 */
class Tag
{

    use Base;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $name;
    /**
     * @var string
     *
     * @ORM\Column(type="string",columnDefinition="ENUM('feedback','intention','category','tag')")
     */
    protected $type;

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

}