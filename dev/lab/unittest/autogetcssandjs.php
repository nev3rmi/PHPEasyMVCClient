<?php require_once($_SERVER['DOCUMENT_ROOT']."/setting/core.php"); ?>
<?php
    $_Core = new _Core;
    $_Array = new _Array;
    $_Core -> AutoGetCoreFiles(_Site::GetRoot().'public/css','css');

    $priorityArrange = array();


    array_push($priorityArrange, 'jquery-3.1.1.min.js');
    array_push($priorityArrange, 'angular.min.js');
    
    $_Core -> AutoGetCoreFiles(_Site::GetRoot().'public/js','js', $priorityArrange);

    // Auto get Private File
    _Ultility::ConsoleData(_Site::GetDocumentPath());

    $_Core -> AutoGetCoreFiles('home/u354635881/public_html/views/index/css','css');

    //$_Core -> AutoGetPrivateCoreFiles(null,'css');
    // // Explode Url
    // $urlExpl = explode('/',_Site::GetDocumentPath());
    // //$urlExpl = explode('/','/dev/lab/unittest');
    // $getEndUrl = end($urlExpl);
    // if (preg_match('/^.*\.?(.php)$/',$getEndUrl)){
    //     array_pop($urlExpl);
    // }
    // array_shift($urlExpl);
    // $fileType = '';
    // foreach ($urlExpl as $url){
    //     $fileType .= '.'.$url;
    //     $_Core -> AutoGetCoreFiles(_Site::GetRoot().'dev/lab/unittest/css',substr($fileType,1).'.css');
    // }
    // $_Core -> AutoGetCoreFiles(_Site::GetRoot().'dev/lab/unittest/css','dev.css');
    // $_Core -> AutoGetCoreFiles(_Site::GetRoot().'dev/lab/unittest/css','dev.lab.css');
    // $_Core -> AutoGetCoreFiles(_Site::GetRoot().'dev/lab/unittest/css','dev.lab.unittest.css');    
?>