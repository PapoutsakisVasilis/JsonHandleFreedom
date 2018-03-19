<?php

/**
 * Created by PhpStorm.
 * User: billpap
 * Date: 3/14/2018
 * Time: 10:59 PM
 */
namespace Freedom\JsonHandler;



class JsonClassFreedom
{
    public function encodeJsonMaster($object, $prepare_mode = false, $encryptPASS = false)
    {
        return JsonEncodeMaster::encode($object, $prepare_mode, $encryptPASS);
    }

    public function jsonDecodeToClass($json, $class = null, $flagTransform = 'class', $encryptPASS = false)
    {
        return JsonDecodeMaster::decode($json, $class, $flagTransform, $encryptPASS);
    }
}