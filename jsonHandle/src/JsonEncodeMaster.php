<?php
/**
 * Created by PhpStorm.
 * User: billpap
 * Date: 3/18/2018
 * Time: 4:58 PM
 */

namespace Freedom\JsonHandler;


class JsonEncodeMaster
{

    public static function encode($object, $prepare_mode = false, $encryptPASS = false)
    {
        $objM  = $object;
        if(is_array($objM)){
            $resultsA = new \stdClass();
            $objArrays = array();
            foreach ($objM as $theArray){
                 $tREs = self::encode($theArray, true);
                array_push($objArrays, $tREs);
            }
            $resultsA->arrayOfObjs = $objArrays;
            return self::encode($resultsA,$prepare_mode,$encryptPASS);
        }
        //static check
        $reflect = new ReflectorFree($objM);
        $ref = $reflect::getProps('static');
        $arrayStatic = array();
        foreach ($ref as $dl)
        {
            if (isset($object::${$dl->name})){
                $propS = $object::${$dl->name};
                $is_json = ValidationsJson::checkJsona($propS);
                if (!$is_json){
                    $fr = [strval($dl->name) => $propS];
                    array_push($arrayStatic, $fr);
                }else{
                    $fr = [strval($dl->name) => PropertyChecker::check($propS)];
                    array_push($arrayStatic, $fr);
                }
            }
        }
        //private check
        $ref = $reflect::getProps('private');
        $arrayPrivate = array();
        foreach ($ref as $dl)
        {
            $meth = 'get_'.$dl->name;
            if($reflect::methodExist($meth)){
                $propP = $object->$meth();
                $is_json = ValidationsJson::checkJsona($propP);
                if (!$is_json){
                    $fr = [strval($dl->name) => $propP];
                    array_push($arrayPrivate, $fr);
                }else{
                    $fr = [strval($dl->name) => PropertyChecker::check($propP)];
                    array_push($arrayPrivate, $fr);
                }
            }
        }
        $allProps = get_object_vars($object);
        foreach ($allProps as $propK => $propV){
            if (ValidationsJson::checkJsona($propV)){
                $object->$propK = PropertyChecker::check($propV);
            }elseif (is_object($propV)){
                $object->$propK = self::encode($propV, true);
            }
        }
        $object->FrStatic = $arrayStatic;
        $object->FrPrivate = $arrayPrivate;
        if (!$prepare_mode){
            if ($encryptPASS != false){
                $theObject = json_encode($object);
                $encrypterJson = new JsonEncryption();
                $encrypterJson->set_pass($encryptPASS);
                return $encrypterJson->encryptJson($theObject);
            }else{
                return json_encode($object);
            }

        }else{
            return $object;
        }
    }

}