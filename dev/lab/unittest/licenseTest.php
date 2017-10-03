<?php
namespace PHPEasy\Dev\Lab\Unittest;
require_once($_SERVER['DOCUMENT_ROOT']."/setting/init.core.php"); 
use PHPEasy\Cores as Cores;
// $license = new Cores\_License;
// $license -> CheckLicense();

// POST IP, WebsiteURL

// echo Cores\_Site::GetClientIP();
// echo Cores\_Site::GetUrl();
echo Cores\_Security::CreateSalt();
?>