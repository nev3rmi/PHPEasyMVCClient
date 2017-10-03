<?php
//
// ──────────────────────────────────────────────────────────────────────────────────────────────── I ──────────
//   :::::: W E L C O M E   T O   P H P E A S Y   F R A M E W O R K : :  :   :    :     :        :          :
// ──────────────────────────────────────────────────────────────────────────────────────────────────────────
// ::::::   Made by NeV3RmI
// ::::::   Copyright (c) 2013 - 2016
//

namespace PHPEasy;
use PHPEasy\Cores as Cores;
require_once("setting/init.core.php");


// Check If ?i=1
if (!empty($_GET['i'])){
    // Remove it
    header('Location: '. Cores\_Site::GetFullUrlNoParam());
    exit();
}else{
    $installPathToIgnore = array(
        Cores\_Site::GetUrl().'install',
        Cores\_Site::GetUrl().'install/GetCurrentStep',
        Cores\_Site::GetUrl().'install/SaveCurrentStep',
        Cores\_Site::GetUrl().'install/SaveKey',
        Cores\_Site::GetUrl().'install/SaveDb',
        Cores\_Site::GetUrl().'install/CheckKeyLicenseWithServer',
        Cores\_Site::GetUrl().'install/SaveContentCode',
        Cores\_Site::GetUrl().'install/SaveGoogleCaptcha'
    );

    if ((new Cores\_Database) -> IsDbConnected() || in_array(Cores\_Site::GetFullUrlNoParam(), $installPathToIgnore)){
        // Inititate Bootstrap
        new Cores\_Bootstrap;
    }else{
        header('Location: '. Cores\_Site::GetUrl().'install');
        exit();
    }
}
