<?php
/**
 * Created by PhpStorm.
 * User: billpap
 * Date: 3/18/2018
 * Time: 5:34 PM
 */

namespace Freedom\JsonHandler;


class JsonDecodeMaster
{
    public static function decode($json, $class = null, $flagTransform = 'class', $encryptPASS = false)
    {

        if ($encryptPASS != false)
        {
            $decrypter = new JsonEncryption();
            $decrypter->set_pass($encryptPASS);
            $json = $decrypter->decryptJson($json);
        }

        if($json === false) return $json;
        if (is_null($class)) $class = \stdClass::class;
        if (ValidationsJson::checkJsona($json)){
            $simpleClass = json_decode($json, true);
            $base = new ReflectorFree($class);
            $baseP = $base::instanceRequest();
            if (is_array($simpleClass)){
                foreach ($simpleClass as $propK => $propV){
                    switch ($propK){
                        case 'FrStatic':{
                            if (strcmp($class, \stdClass::class) == 0){
                                $baseP->$propK = PropertyChecker::check($propV, $flagTransform);
                                break;
                            }
                            foreach ($propV as $staticRec){
                                foreach ($staticRec as $staticKey => $staticValue){
                                    $baseP::${$staticKey} = PropertyChecker::check($staticValue, $flagTransform);
                                }
                            }
                            break;
                        }
                        case 'FrPrivate':{
                            if (strcmp($class, \stdClass::class) == 0){
                                $baseP->$propK = PropertyChecker::check($propV, $flagTransform);
                                break;
                            }
                            foreach ($propV as $privateRec){
                                foreach ($privateRec as $staticKey => $staticValue){
                                    $meth = 'set_'.$staticKey;
                                    if($base::methodExist($meth)){
                                        $baseP->$meth(PropertyChecker::check($staticValue, $flagTransform));
                                    }
                                }
                            }
                            break;
                        }
                        default:{
                            $baseP->$propK = PropertyChecker::check($propV, $flagTransform);
                        }
                    }
                }
            }
            return $baseP;
        }else{
            return $json;
        }
    }

}