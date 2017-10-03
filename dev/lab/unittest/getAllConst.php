<?php require_once($_SERVER['DOCUMENT_ROOT']."/setting/core.php"); ?>
<?php
use PHPEasy\Cores as Cores;
$const = Cores\_Site::GetConst('PHPEasy\Cores\_Permission');
print_r($const);