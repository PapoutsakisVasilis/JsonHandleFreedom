<?php
/**
 * Created by PhpStorm.
 * User: billpap
 * Date: 3/18/2018
 * Time: 5:33 PM
 */

namespace Freedom\JsonHandler;

use ReflectionClass;
use ReflectionProperty;


class ReflectorFree
{

    public static $classReflection;

    public function __construct($objM)
    {
        $this::$classReflection = new ReflectionClass($objM);
        return $this;
    }

    public static function classReflect()
    {
        return self::$classReflection;
    }

    public static function getProps($type)
    {
        switch ($type){
            case 'static':{
                $static = self::$classReflection->getProperties(ReflectionProperty::IS_STATIC);
                return $static;
            }
            case 'private':{
                $private = self::$classReflection->getProperties(ReflectionProperty::IS_PRIVATE);
                return $private;
            }
            default:{
                return false;
            }
        }
    }

    public static function methodExist($meth)
    {
        return self::$classReflection->hasMethod($meth);
    }

    public static function instanceRequest()
    {
        return self::$classReflection->newInstance();
    }

}