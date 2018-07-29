<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 7/28/18
 * Time: 11:17 AM
 */

namespace Cms\View;


use Cms\Entity\WeChatUser;
use Cms\Entity\Work;
use Cms\Entity\WorkImage;

class WorkVoteAndUser extends WorkVote
{

    public $wxOpenId;
    public $nickName;
    public $avatar;

    public static function convertByWorkAndWorkImageAndVoteAndUser(Work $work, WorkImage $workImage, $position, $voteNum, WeChatUser $user)
    {
        $workVoteAndUser = new WorkVoteAndUser();
        $workVoteAndUser->id = $work->id;
        $workVoteAndUser->weixin = $work->weiXin;
        $workVoteAndUser->phone = $work->phone;
        $workVoteAndUser->imageUrl = $workImage->imageUrl;
        $workVoteAndUser->description = $work->workDescription;
        $workVoteAndUser->name = $work->workName;
        $workVoteAndUser->city = $work->city;
        $workVoteAndUser->author = $work->author;
        $workVoteAndUser->voteNum = $voteNum;
        $workVoteAndUser->position = $position;
        $workVoteAndUser->isHandle = $work->isHandle;
        $workVoteAndUser->wxOpenId = $user->openid;
        $workVoteAndUser->nickName = $user->nickname;
        $workVoteAndUser->avatar = $user->headImgUrl;
        return $workVoteAndUser;
    }


}