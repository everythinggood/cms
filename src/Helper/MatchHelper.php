<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 7/26/18
 * Time: 9:49 AM
 */

namespace Cms\Helper;


class MatchHelper
{

    public static function isPhone($phoneNum){
        if(preg_match("/^1[34578]{1}\d{9}$/",$phoneNum)){
            return true;
        }
        return false;
    }

}