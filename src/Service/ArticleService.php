<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 6/19/18
 * Time: 10:30 AM
 */

namespace Cms\Service;


use Cms\Entity\Article;
use Cms\Helper\ValidationHelper;
use Doctrine\ORM\EntityManager;

class ArticleService
{
    /**
     * @var EntityManager
     */
    public $em;

    /**
     * ArticleService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param array $data
     * @return Article
     * @throws \Doctrine\ORM\ORMException
     */
    public function addArticle(array $data)
    {
        $article = new Article();
        $article = $this->matchBy($article, $data);
        $article->setCreateTime(new \DateTime());

        $this->em->persist($article);
        $this->em->flush();

        return $article;
    }

    private function matchBy(Article $article, array $data)
    {
        $article->setType($data['type']);
        $article->setTitle($data['title']);
        if($data['author']) $article->setAuthor($data['author']);
        $article->setContent($data['content']);
        $article->setDownloadUrl($data['downloadUrl'] ?: null);
        $article->setStatus($data['status'] ?: Article::STATUS_DEFAULT);
        $article->setUpdateTime(new \DateTime());
        return $article;
    }

    /**
     * @param $id
     * @param array $data
     * @return Article|null|object
     * @throws \Exception
     */
    public function editArticle($id, array $data)
    {
        $article = $this->findById($id);

        ValidationHelper::checkIsTrue($article, "can not found article by [$id]");

        $article = $this->matchBy($article, $data);

        $this->em->persist($article);
        $this->em->flush();

        return $article;
    }

    /**
     * @param $id
     * @return Article|null|object
     * @throws \Exception
     */
    public function pushTop($id)
    {
        $article = $this->findById($id);

        ValidationHelper::checkIsTrue($article, 'can not found article');

        $article->setStatus(Article::STATUS_TOP);

        $this->em->persist($article);
        $this->em->flush();

        return $article;
    }

    /**
     * @param $id
     * @return Article|null|object
     */
    public function findById($id)
    {
        return $this->em->getRepository(Article::class)->find($id);
    }

    /**
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function deleteById($id)
    {
        $article = $this->findById($id);
        ValidationHelper::checkIsTrue($article, "can not found article by [$id]");

        $this->em->remove($article);
        $this->em->flush();

        return true;
    }

    public function findByType($type)
    {

        if($type == Article::TYPE_ALL) return $this->em->getRepository(Article::class)->findAll();

        return $this->em->getRepository(Article::class)->findBy([
            'type' => $type
        ], [
            'status' => 'asc',
            'updateTime' => 'desc',
        ]);
    }

    public function findTopArticles($type)
    {
        return $this->em->getRepository(Article::class)->findBy(
            ["type" => $type, 'status' => Article::STATUS_TOP], ['updateTime' => 'desc']);
    }


}