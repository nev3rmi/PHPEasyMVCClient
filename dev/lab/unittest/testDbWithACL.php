<?php
namespace PHPEasy\Dev\Lab\Unittest;
require_once($_SERVER['DOCUMENT_ROOT']."/setting/init.core.php"); 

$db = new \PHPEasy\Cores\_Database;
// $session = new \PHPEasy\Cores\_Session;

if ($db -> IsDbConnected()){
    $a = $db -> Insert('Controller', array(
        'ControllerName' => 'TestMe1'
    ));
    $db -> CreateObjectAcl('Controller', $a, 1);
    echo $db -> GetObjectAcl('Controller', $a);
}else{
    echo "Khong chay";
}
