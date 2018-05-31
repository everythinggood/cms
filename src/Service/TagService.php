<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/24/18
 * Time: 4:30 PM
 */

namespace Cms\Service;


use Cms\Entity\Tag;
use Doctrine\ORM\EntityManager;

class TagService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * TagService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param array $data
     * @return Tag
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createTag(array $data){
        $tag = new Tag();
        $tag->setCreateTime(new \DateTime());
        $tag->setUpdateTime(new \DateTime());
        $tag->setName($data['name']);
        $tag->setType($data['type']);

        $this->em->persist($tag);
        $this->em->flush();

        return $tag;
    }


}