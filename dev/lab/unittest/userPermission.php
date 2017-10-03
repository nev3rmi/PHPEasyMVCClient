<?php 
namespace  PHPEasy\Dev;
use PHPEasy\Cores as Cores;

require_once($_SERVER['DOCUMENT_ROOT']."/setting/core.php");

// $permission = new _Permission;
// $permission -> Set(_Permission::Write);

// if ($permission -> Get(_Permission::Write)){
//     echo "Yes";
// }else{
//     echo "No";
// }

// $user = new _User;
// $userPermission = 3;
// // Preset -> This set rule must base on page
// $user -> role -> Set($userPermission);
// // Check if allow to do so.
// echo $user -> role -> Get(4);


$user = new Cores\_Permission;
$userPermission = 15;
// Preset -> This set rule must base on page
$user -> Set($userPermission);
// Check if allow to do so.
echo $user ->  Get(1);
?>