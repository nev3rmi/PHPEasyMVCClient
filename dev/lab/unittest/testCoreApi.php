<?php require_once($_SERVER['DOCUMENT_ROOT']."/setting/core.php"); ?>
<?php
use PHPEasy\Cores as Cores;
try{
    $FileSyncApi = new Cores\_Plugin('test/test');
    print_r($FileSyncApi -> apiClass);

    $FileSyncApi -> Api = new \Test();
    $FileSyncApi -> Api -> echoMe();
}catch (\Exception $e){
    (new Cores\_Error) -> ShowError($e -> getMessage());
}
?>