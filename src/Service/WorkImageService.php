<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 7/24/18
 * Time: 10:55 AM
 */

namespace Cms\Service;


use Cms\Entity\WorkImage;
use Doctrine\ORM\EntityManager;

class WorkImageService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * WorkImageService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param $workNo
     * @param $imageUrl
     * @return WorkImage
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createWorkImage($workNo, $imageUrl){
        $workImage = $this->initWorkImage($workNo,$imageUrl);

        $this->em->persist($workImage);
        $this->em->flush();

        return $workImage;
    }

    private function initWorkImage($workNo,$imageUrl){
        $workImage = new WorkImage();
        $workImage->setUpdateTime(new \DateTime());
        $workImage->setCreateTime(new \DateTime());
        $workImage->setWorkNo($workNo);
        $workImage->setImageUrl($imageUrl);
        return $workImage;
    }

    /**
     * @param $workNo
     * @param array $imageUrls
     * @return array
     * @throws \Doctrine\ORM\ORMException
     */
    public function createWorkImages($workNo, array $imageUrls){

        $result = [];

        foreach ($imageUrls as $key=>$imageUrl){
            $workImage = $this->initWorkImage($workNo,$imageUrl);

            $this->em->persist($workImage);
            $result[$key] =  $workImage;
        }
        $this->em->flush();

        return $result;
    }

    /**
     * @param $id
     * @return WorkImage|null|object
     */
    public function findByWorkNo($id)
    {
        return $this->em->getRepository(WorkImage::class)->findOneBy(['workNo'=>$id]);
    }

}