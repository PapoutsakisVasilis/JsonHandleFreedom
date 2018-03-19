<?php
/**
 * Created by PhpStorm.
 * User: billpap
 * Date: 3/18/2018
 * Time: 5:40 PM
 */

namespace Freedom\JsonHandler;



class PropertyChecker
{
    public static function check($value, $flagTransform = 'class')
    {
        if (is_null($value)||is_double($value)||(is_string($value)&&!ValidationsJson::checkJsona($value))||is_integer($value)){
            return $value;
        }
        if(ValidationsJson::checkJsona($value)){
            $val = JsonDecodeMaster::decode($value,null,$flagTransform);
            return $val;
        }
        switch ($flagTransform){
            case 'class':{
                if (is_array($value)){
                    if(!ValidationsJson::isAssocArr($value)){
                        $main = array();
                        foreach ($value as $valK => $valV){
                            $main["$valK"] = self::check($valV,$flagTransform);
                        }
                        return $main;
                    }elseif(ValidationsJson::isAssocArr($value)){
                        $obj = new \stdClass();
                        foreach ($value as $valK => $valV){
                            $obj->$valK = self::check($valV,$flagTransform);
                        }
                        return $obj;
                    }
                }
                return $value;
                break;
            }
            case 'array':{
                if (is_array($value)){
                    $main = array();
                    foreach ($value as $valK => $valV){
                        $main["$valK"] = self::check($valV,$flagTransform);
                    }
                    return $main;
                }
                return $value;
                break;
            }
            default :{
                return $value;
                break;
            }
        }
    }
}