<?php
namespace PHPEasy\Views;
use PHPEasy\Cores as Cores;
?>
<!DOCTYPE html>
<?php header('Content-type: text/html; charset=utf-8');?>
<html ng-app="PHPEasy">
    <head>
        <meta charset="utf-8">
        <?php require_once "views/_layout/head/_meta.php"; ?>
        <title><?php echo $this->title.' | '.Cores\_Security::GetKey('siteName');?></title>
    </head>
    <body>
    <?php 
    if (!$this->navbar->IsHide){
        require_once "views/_layout/head/_navbar.php"; 
    }
    ?>
    <?php require_once "views/_layout/head/_header.php"; ?>
    <div class="container-full" id="main-app">
