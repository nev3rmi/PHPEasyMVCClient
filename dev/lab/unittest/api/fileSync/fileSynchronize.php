<?php require_once($_SERVER['DOCUMENT_ROOT']."/setting/core.php"); ?>
<?php
use PHPEasy\Cores as Cores;



$fileA = Cores\_Site::GetRoot()."dev/lab/unittest/api/fileSync/texta.txt";
$fileB = Cores\_Site::GetRoot()."dev/lab/unittest/api/fileSync/textb.txt";


xdiff_file_diff($fileA, $fileB, tmpfile(), 2);
















// =============== Failed

// require_once(Cores\_Site::GetRoot().'setting/api/php-file-sync/file_synchronizer.php');
// try{
//     $FileSyncApi = new Cores\_Plugin('test/test');
//     print_r($FileSyncApi -> apiClass);

//     $FileSyncApi -> Api = new \Test();
//     $FileSyncApi -> Api -> echoMe();
// }catch (\Exception $e){
//     (new Cores\_Error) -> ShowError($e -> getMessage());
// }


// try{
//     $FileCLash = new Cores\_Plugin('test/testClash');
// }catch (\Exception $e){
//     (new Cores\_Error) -> ShowError($e -> getMessage());
// }

// print_r(Cores\_Site::GetClass());


// try{
//     $init = new Cores\_Plugin('php-file-sync/file_synchronizer');
    
//     $settings = array();
//     $settings["simulate"]  = false;
//     $settings["skip_hidden"] = true;
//     $settings["use_checksum"] = false;
//     $settings["path_a"] = Cores\_Site::GetRoot()."dev/lab/unittest/api/fileSync/texta.txt";
//     $settings["path_b"] = Cores\_Site::GetRoot()."dev/lab/unittest/api/fileSync/textb.txt";
//     $file_synchronizer = new \File_Synchronizer($settings);

//     try
//     {
//         // Start the synchronization
//         $file_synchronizer->start_sync();
//     }
//     catch(\Synchronization_Exception $sync_ex)
//     {
//         // Do something here to handle a synchronization exception
//         throw $sync_ex;
//     }

// }catch (\Exception $e){
//     (new Cores\_Error) -> ShowError($e -> getMessage());
// }

?>