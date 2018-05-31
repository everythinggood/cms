<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/25/18
 * Time: 2:07 PM
 */

namespace Cms\Entity\ex;


trait BaseProperty
{
    use Base;

    static $pending = 'pending';
    static $done = 'done';

    /**
     * @var string
     *
     * @ORM\Column(name="is_handle",type="string",columnDefinition="ENUM('pending','done')")
     */
    public $isHandle;

    /**
     * @return string
     */
    public function getisHandle()
    {
        return $this->isHandle;
    }

    /**
     * @param string $isHandle
     */
    public function setIsHandle($isHandle)
    {
        $this->isHandle = $isHandle;
    }

}