<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 6/19/18
 * Time: 10:57 AM
 */

namespace Cms\Service;


use Cms\Entity\Navigation;
use Cms\Helper\ValidationHelper;
use Doctrine\ORM\EntityManager;

class NavigationService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * NavigationService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param array $data
     * @return Navigation
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addNavigation(array $data)
    {
        $navigation = new Navigation();
        $navigation->setCreateTime(new \DateTime());
        $navigation = $this->matchBy($navigation, $data);

        $this->em->persist($navigation);
        $this->em->flush();

        return $navigation;

    }

    private function matchBy(Navigation $navigation, array $data)
    {
        $navigation->setName($data['name']);
        $navigation->setHref($data['href'] ?: null);
        $navigation->setInheritId($data['inheritId'] ?: 0);
        $navigation->setZIndex($data['zIndex']);
        $navigation->setUpdateTime(new \DateTime());

        return $navigation;
    }

    /**
     * @param $id
     * @param array $data
     * @return Navigation|null|object
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function editNavigation($id, array $data)
    {
        $navigation = $this->findById($id);

        ValidationHelper::checkIsTrue($navigation, "can not found navigation by [$id]");

        $navigation = $this->matchBy($navigation, $data);

        $this->em->persist($navigation);
        $this->em->flush();

        return $navigation;
    }

    public function findById($id)
    {
        return $this->em->getRepository(Navigation::class)->find($id);
    }

    /**
     * @param $id
     * @return Navigation|null|object
     * @throws \Exception
     */
    public function deleteById($id)
    {
        $navigation = $this->findById($id);

        ValidationHelper::checkIsTrue($navigation, "can not found navigation by [$id]");

        $this->em->remove($navigation);
        $this->em->flush();

        return $navigation;
    }

    public function findAll()
    {
        $result = [];

        $topNavigationArr = $this->em->getRepository(Navigation::class)->findBy(['zIndex' => 0], ['updateTime' => 'desc']);

        foreach ($topNavigationArr as $topNavigation) {
            $result[$topNavigation->id] = (array)$topNavigation;
            $result[$topNavigation->id]['subNavigations'] = (array)$this->findByInheritIdAndZIndex(1, $topNavigation->id);
        }

        return $result;
    }

    public function all(){
        return $this->em->getRepository(Navigation::class)->findAll();
    }

    public function findByInheritIdAndZIndex($zIndex, $inheritId)
    {
        return $this->em->getRepository(Navigation::class)->findBy(['inheritId' => $inheritId, 'zIndex' => $zIndex],['updateTime'=>'asc']);
    }

    public function findTopNavigations(){
        return $this->em->getRepository(Navigation::class)->findBy(['zIndex'=>0]);
    }
}