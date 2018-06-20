<?php
/**
 * Created by PhpStorm.
 * User: ycy
 * Date: 5/31/18
 * Time: 10:44 AM
 */

namespace Cms\Helper;


class TemplateHelper
{

    public static function generateSelectOptions($optionValues,$selected = null){

        $content = '';
        foreach ($optionValues as $optionKey=>$optionValue){

            $selectedOption = $optionKey===$selected?'selected':'';

            $content .= "<option value=\"$optionKey\" $selectedOption>$optionValue</option>".PHP_EOL;
        }

        return $content;

    }

}