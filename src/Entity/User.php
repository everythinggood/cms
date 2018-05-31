<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/24/18
 * Time: 12:48 PM
 */

namespace Cms\Entity;
use Cms\Entity\ex\Base;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package Cms\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="user")
 */
class User
{

    use Base;
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    public $name;
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    public $password;
    /**
     * @var string
     *
     * @ORM\Column(type="string",columnDefinition="ENUM('admin')")
     */
    public $role;

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
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

}