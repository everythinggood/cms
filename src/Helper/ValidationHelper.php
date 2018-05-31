<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/24/18
 * Time: 6:09 PM
 */

namespace Cms\Helper;


class ValidationHelper
{


    /**
     * @param $examiner
     * @param $name
     * @throws \Exception
     */
    public static function checkIsNull($examiner,$name){
        if(!$examiner) throw new \Exception("require [$name] parameter!");
    }

    /**
     * @param $examiner
     * @param $name
     * @throws \Exception
     */
    public static function checkIsTrue($examiner, $name){
        if(!$examiner) throw new \Exception($name);
        if(is_array($examiner)&&count($examiner) < 0) throw new \Exception($name);
    }

    /**
     * @param $examiner
     * @param $compare
     * @param $name
     * @throws \Exception
     */
    public static function checkIsBig($examiner, $compare, $name){
        if($examiner > $compare) throw new \Exception($name);
    }


}