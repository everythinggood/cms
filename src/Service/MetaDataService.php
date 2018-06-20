<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 6/19/18
 * Time: 10:43 AM
 */

namespace Cms\Service;


use Cms\Entity\MetaData;
use Cms\Helper\ValidationHelper;
use Doctrine\ORM\EntityManager;

class MetaDataService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * MetaDataService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param array $data
     * @return MetaData
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addMetaData(array $data)
    {
        $metaData = new MetaData();
        $metaData->setType($data['type']);
        $metaData->setDownloadUrl($data['downloadUrl']);
        $metaData->setStatus(MetaData::STATUS_UP);
        $metaData->setCreateTime(new \DateTime());
        $metaData->setUpdateTime(new \DateTime());

        $this->em->persist($metaData);
        $this->em->flush();
        return $metaData;
    }

    /**
     * @param array $datas
     * @param $type
     * @return array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addMultipleMetaData(array $datas,$type)
    {
        $result = [];
        foreach ($datas as $data) {
            $metaData = new MetaData();
            $metaData->setType($type);
            $metaData->setDownloadUrl($data);
            $metaData->setStatus(MetaData::STATUS_UP);
            $metaData->setCreateTime(new \DateTime());
            $metaData->setUpdateTime(new \DateTime());

            $this->em->persist($metaData);
            $result[] = (array)$metaData;
        }
        $this->em->flush();

        return $result;
    }

    /**
     * @param $id
     * @param array $data
     * @return MetaData|null|object
     * @throws \Exception
     */
    public function editMetaData($id, array $data)
    {
        $metaData = $this->findById($id);

        ValidationHelper::checkIsTrue($metaData, "can not found metaData by [$id]");

        $this->copyUpToDown($metaData);

        if ($data['type']) $metaData->setType($data['type']);
        if ($data['downloadUrl']) $metaData->setDownloadUrl($data['downloadUrl']);
        $metaData->setUpdateTime(new \DateTime());

        $this->em->persist($metaData);
        $this->em->flush();

        return $metaData;
    }

    /**
     * @param MetaData $upMetaData
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function copyUpToDown(MetaData $upMetaData)
    {
        $metaData = new MetaData();
        $metaData->setType($upMetaData->type);
        $metaData->setDownloadUrl($upMetaData->downloadUrl);
        $metaData->setStatus(MetaData::STATUS_DOWN);
        $metaData->setCreateTime(new \DateTime());
        $metaData->setUpdateTime(new \DateTime());

        $this->em->persist($metaData);
        $this->em->flush();
    }

    public function findById($id)
    {
        return $this->em->getRepository(MetaData::class)->find($id);
    }

    /**
     * @param $id
     * @return MetaData|object
     * @throws \Exception
     */
    public function deleteById($id)
    {
        $metaData = $this->findById($id);
        ValidationHelper::checkIsTrue($metaData, "can not found metaData by [$id]");

        $metaData->setStatus(MetaData::STATUS_DOWN);
        $this->em->persist($metaData);
        $this->em->flush();

        return $metaData;
    }

    public function findByType($type)
    {

        if ($type == MetaData::TYPE_ALL) return $this->em->getRepository(MetaData::class)->findBy(['status' => MetaData::STATUS_UP]);

        return $this->em->getRepository(MetaData::class)->findBy([
            'type' => $type,
            'status' => MetaData::STATUS_UP
        ], ['updateTime' => 'desc']);
    }

    public function findAll()
    {
        return $this->em->getRepository(MetaData::class)->findby([],['status'=>'asc']);
    }


}