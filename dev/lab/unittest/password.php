<?php
namespace PHPEasy\Dev\Lab\Unittest;
require_once($_SERVER['DOCUMENT_ROOT']."/setting/init.core.php"); 
use PHPEasy\Cores as Cores;
$hashPassword = Cores\_Security::HashKey('Qwerty123!');
$password = Cores\_Security::HashEncryptedWithSalt($hashPassword);
echo $password;

?>