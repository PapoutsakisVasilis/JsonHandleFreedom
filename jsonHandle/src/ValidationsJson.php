<?php
/**
 * Created by PhpStorm.
 * User: billpap
 * Date: 3/18/2018
 * Time: 5:19 PM
 */

namespace Freedom\JsonHandler;


class ValidationsJson
{
    public static function checkJsona($json)
    {
        if (is_array($json)){
            return false;
        }
        return is_string($json) && is_array(json_decode($json, true)) ? true : false;
    }

    public static function isAssocArr(array $array)
    {
        if (array() === $array) return false;
        return array_keys($array) !== range(0, count($array) - 1);
    }

}