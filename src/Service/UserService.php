<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/24/18
 * Time: 4:33 PM
 */

namespace Cms\Service;


use Cms\Entity\User;
use Doctrine\ORM\EntityManager;

class UserService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * UserService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param array $data
     * @return User
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createUser(array $data){

        $user = $this->findByUserNameAndPassword($data['name'],$data['password']);

        if($user) return $user;

        $user = new User();
        $user->setName($data['name']);
        $user->setUpdateTime(new \DateTime());
        $user->setCreateTime(new \DateTime());
        $user->setPassword(base64_encode(md5($data['password'])));
        $user->setRole($data['role']);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    public function findByUserNameAndPassword($userName,$password){
        /** @var User $user */
        $user = $this->em->getRepository(User::class)->findOneBy([
           'name'=>$userName,
           'password'=>base64_encode(md5($password))
        ]);

        return $user;
    }

    /**
     * @param User $user
     * @param $password
     * @return User
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updatePasswordByUser(User $user, $password){
        $user->setPassword(base64_encode(md5($password)));

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * @param User $user
     * @param $userName
     * @return User
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateNameByUser(User $user, $userName){
        $user->setName($userName);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * @param User $user
     * @param $role
     * @return User
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateRoleByUser(User $user, $role){
        $user->setRole($role);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }


}