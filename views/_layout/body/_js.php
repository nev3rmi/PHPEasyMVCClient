<?php
namespace PHPEasy\Views\Js;
use PHPEasy\Cores as Cores;
?>
<!-- Js -->
<?php
$_Core = new Cores\_Core;
$_Array = new Cores\_Array;
$_Ultility = new Cores\_Ultility;

$priorityArrange = array();
array_push($priorityArrange, 'jquery-3.1.1.min.js');
array_push($priorityArrange, 'angular.min.js');
array_push($priorityArrange, 'bootstrap.js');
array_push($priorityArrange, 'jquery.dataTables.min.js');
array_push($priorityArrange, 'phpeasy.js');
array_push($priorityArrange, 'phpeasy.page.js');
array_push($priorityArrange, 'phpeasy.plugins.js');
array_push($priorityArrange, 'phpeasy.plugins.custom.js');
array_push($priorityArrange, 'phpeasy.plugins.custom.bootstrap.js');
array_push($priorityArrange, 'phpeasy.plugins.oauth.js');
array_push($priorityArrange, 'phpeasy.page.sitemap.js');

$lowpriorityArrange = array();
array_push($lowpriorityArrange, 'initial.js');

// $_Core -> AutoGetCoreFiles(Cores\_Site::GetRoot().'public/js','js', $priorityArrange);

$_Core -> AutoGetCoreFiles(Cores\_Site::GetRoot().'public/js','js', $priorityArrange, $lowpriorityArrange, true);

// Get Protected and Private Core File
$breakPath = $_Site -> GetDocumentBreakDownPath();
$jsPath = Cores\_Site::GetRoot().'views/'.$breakPath[1];
$_Core -> AutoGetPrivateCoreFiles($jsPath,'js');
?>