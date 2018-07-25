<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 7/24/18
 * Time: 10:39 AM
 */

namespace Cms\Entity;
use Cms\Entity\ex\Base;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class WorkImage
 * @package Cms\Entity
 * @ORM\Entity
 * @ORM\Table(name="work_image")
 */
class WorkImage
{
    use Base;

    /**
     * @var string
     * @ORM\Column(name="work_no",type="string")
     */
    public $workNo;
    /**
     * @var string
     * @ORM\Column(name="image_url",type="string")
     */
    public $imageUrl;

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

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @param string $imageUrl
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }

}