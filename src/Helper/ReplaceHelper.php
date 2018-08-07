<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 8/7/18
 * Time: 10:39 AM
 */

namespace Cms\Helper;


class ReplaceHelper
{

    public static function replaceWechatEmoil($nickname){
        return preg_replace('/\\\u[a-z0-9]{4}/', '*',$nickname);
    }

}