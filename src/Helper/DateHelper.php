<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 8/8/18
 * Time: 3:03 PM
 */

namespace Cms\Helper;


class DateHelper
{

    /**
     * @param $compare
     * @param $limit
     * @return bool
     * @throws \Exception
     */
    public static function isEarly($compare, $limit){

        if(!is_string($compare)||!is_string($limit))  throw new \Exception("option must string type");

        if(strtotime($compare)<strtotime($limit)) return true;

        return false;
    }

}