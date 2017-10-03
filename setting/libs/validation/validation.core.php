<?php
namespace PHPEasy\Cores;
class _Validation{

    function Regex($data,$arg){
        if (!preg_match($arg,$data)){
            return "Your string need to match with the requirement"; 
        }
    }

    function MinLength($data, $arg){
        if (strlen($data) < $arg) {
            return "Your string can only be $arg long";
        }
    }

    function MaxLength($data, $arg){
        if (strlen($data) > $arg) {
            return "Your string can only be $arg long";
        }
    }

    function Digit($data){
        if (ctype_digit($data) == false) {
            return "Your string must be a digit";
        }
    }

    function ExactlyMatch($data, $arg){
        if ($data != $arg){
            return "Your string must be match exactly with another";
        }
    }

    function __call($name, $arguments){
        throw new \Exception("$name does not exist inside of: " . __CLASS__);
    }
}
?>