<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 7/24/18
 * Time: 6:13 PM
 */

namespace Cms\View;


use Cms\Entity\Work;
use Cms\Entity\WorkImage;

class WorkVote
{
    public $id;
    public $author;
    public $city;
    public $phone;
    public $weixin;
    public $name;
    public $description;
    public $imageUrl;
    /**
     * 票数
     * @var
     */
    public $voteNum;
    /**
     * 名次
     * @var
     */
    public $position;

    public static function convertByWorkAndWorkImageAndVote(Work $work,WorkImage $workImage,$position,$voteNum){
        $workVote = new WorkVote();
        $workVote->id = $work->id;
        $workVote->weixin = $work->weiXin;
        $workVote->phone = $work->phone;
        $workVote->imageUrl = $workImage->imageUrl;
        $workVote->description = $work->workDescription;
        $workVote->name = $work->workName;
        $workVote->city = $work->city;
        $workVote->author = $work->author;
        $workVote->voteNum = $voteNum;
        $workVote->position = $position;
        return $workVote;
    }
}