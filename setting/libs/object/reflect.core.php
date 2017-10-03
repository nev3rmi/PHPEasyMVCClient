<?php
// TODO: Cannot Use Yet, Bug
namespace PHPEasy\Cores;
class ObjectMirror extends \ReflectionObject{
    public $_object = null;
    public $_property = null;
    public $_value = null;
    
    function __construct($object, $property){
        $this -> Set($object, $property);
    }

    private function Set($object, $property){
        $reflectObject = new \ReflectionObject($object);
        $objectProperty = $reflectObject->getProperty($property);
        $value = $objectProperty->getValue($object);
        
        $this -> _object = $object;
        $this -> _property = $property;
        $this -> _value = $value;
    }
}
