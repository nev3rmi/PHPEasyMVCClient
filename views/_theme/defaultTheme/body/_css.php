<?php
namespace PHPEasy\Views\Css;
use PHPEasy\Cores as Cores;
?>
<!-- Css -->
<?php
$_Core = new Cores\_Core;
$_Site = new Cores\_Site;
$_Ultility = new Cores\_Ultility;

$_Core -> AutoGetCoreFiles(Cores\_Site::GetRoot().'public/css','css');


// Get Protected and Private Core File
$breakPath = $_Site -> GetDocumentBreakDownPath();
$cssPath = Cores\_Site::GetRoot().'views/'.$breakPath[1];
$_Core -> AutoGetPrivateCoreFiles($cssPath,'css');
?>