<?php
namespace PHPEasy\Views;
use PHPEasy\Cores as Cores;
?>
<!doctype html>
<?php header('Content-type: text/html; charset=utf-8');?>
<html>
<head>
<meta charset="utf-8">
<?php require_once "views/_layout/head/_meta.php"; ?>
<title><?php echo $this->title.' | '.Cores\_Security::GetKey('siteName');?></title>
</head>
<body>
<?php require_once "views/_layout/head/_navbar.php"; ?>
<?php require_once "views/_layout/head/_header.php"; ?>
<div class="container-fluid" id="main-app">
