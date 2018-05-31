<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/24/18
 * Time: 4:24 PM
 */

namespace Cms\Service;


use Cms\Entity\Question;
use Cms\Helper\ValidationHelper;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator;

class QuestionService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * QuestionService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param array $data
     * @return Question
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createQuestion(array $data)
    {
        $question = new Question();
        $question = $this->autoSetUpQuestion($question,$data);

        $this->em->persist($question);
        $this->em->flush();

        return $question;
    }

    /**
     * @param $page
     * @param $itemPerPage
     * @return array
     * @throws \Exception
     */
    public function findAllByPage($page, $itemPerPage)
    {

        $count = $this->em->getRepository(Question::class)->count([]);

        $totalPage = ceil($count / $itemPerPage);

        ValidationHelper::checkIsBig($page, $totalPage, 'this page is not allow!');

        $questions = $this->em->getRepository(Question::class)->findBy([], null, $itemPerPage, ($page - 1) * $itemPerPage);

        $result = [];
        foreach ($questions as $question) {
            $result['data'][] = (array)$question;
        }

        $result['page'] = $page;
        $result['itemPerPage'] = $itemPerPage;
        $result['count'] = $count;
        $result['totalPage'] = $totalPage;

        return $result;
    }

    /**
     * @param $id
     * @return Question
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function findById($id)
    {
        /** @var Question $question */
        $question = $this->em->find(Question::class, $id);

        return $question;
    }

    /**
     * @param array $data
     * @return Question
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function updateQuestionById(array $data)
    {
        $question = $this->findById($data['id']);
        $question = $this->autoSetUpQuestion($question,$data);

        $this->em->persist($question);
        $this->em->flush();

        return $question;
    }

    protected function autoSetUpQuestion(Question $question, array $data)
    {
        $question->setCreateTime(new \DateTime());
        $question->setUpdateTime(new \DateTime());
        $question->setAnswer($data['answer']);
        $question->setCategory($data['category']);
        $question->setQuestion($data['question']);
        $question->setTags($data['tags'] ?: null);
        $question->setType($data['type']);
        if($data['weight']) $question->setWeight($data['weight']);

        return $question;
    }

    /**
     * @param $id
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @throws \Exception
     */
    public function deleteById($id){

        $question = $this->findById($id);

        ValidationHelper::checkIsTrue($question,"can not find by [$id]");

        $this->em->remove($question);
        $this->em->flush();

        return true;
    }

    /**
     * @param $id
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @throws \Exception
     */
    public function pushTop($id){
        $question = $this->findById($id);

        ValidationHelper::checkIsTrue($question,'can not find by [$id]');

        $question->setWeight(101);

        $this->em->persist($question);
        $this->em->flush($question);

        return true;

    }

    public function getCategorys(){
        return array_keys(Question::$sellerCategorys);
    }

    /**
     * @return mixed
     */
    public function getTopQuestions($type){

        $query = $this->em->createQuery("select q from Cms\\Entity\\Question q where q.weight > 100 and q.type = :type");
        $query->setParameter('type',$type);

        return $query->getResult();

    }

    /**
     * @param $category
     * @return array
     * @throws \Exception
     */
    public function findByCategory($category,$type){

        if(!$category) return $this->findAllByPage(1,30);

        $query = $this->em->createQuery("select q from Cms\\Entity\\Question q where q.category = :category and q.type = :type");
        $query->setParameter('category',$category);
        $query->setParameter('type',$type);

        return $query->getResult();

    }

    public function getUserQuestions(){
        $query = $this->em->createQuery("select q from Cms\\Entity\\Question q where q.type = 'user'");
        return $query->getResult();
    }
}