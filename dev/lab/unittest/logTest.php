<?php 
namespace PHPEasy\Dev\Lab\Unittest;
require_once($_SERVER['DOCUMENT_ROOT']."/setting/core.php"); 
use PHPEasy\Cores as Cores;
class logTest{
    function __construct(){
        $this -> testLog();
        echo "<br>";
        $this -> testLog2();
    }

    function testLog(){
        $log = new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__); 
        $log -> WriteLog('Test', '1');
    }

    function testLog2(){
        (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Test', '1');
    }
}

$logTest = new logTest;
?>