<?php require_once($_SERVER['DOCUMENT_ROOT']."/setting/core.php"); ?>
<?php
$page = new _Page;
// echo $page -> pageUrl;
// $page -> pageUrl = 'index';
$page -> SetPageInformation(null, 'index', 'index');
echo $page -> pageId;
?>