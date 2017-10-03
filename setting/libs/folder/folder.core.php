<?php
namespace PHPEasy\Cores;
class _Folder{
	function GetFiles($path){
		return array_diff(scandir($path),array('..', '.'));	
	}
	function GetFilesWithType($path, $fileType){
		$listOfAllFile = array_diff(scandir($path),array('..', '.'));
		return preg_grep("/^.*\.(".$fileType.")$/", $listOfAllFile);
	}
	public static function CreateFolder($fullPath, $permission = 0755){
		$pathExpl = explode('/', $fullPath);
        $pathExpl = array_slice($pathExpl, 1, -1);
        $rootExpl = explode('/', _Site::GetRoot());
        $rootExpl = array_slice($rootExpl, 1, -1);
        $path = _Site::GetRoot();
        for ($x = count($rootExpl); $x < count($pathExpl); $x++){
            $path .= $pathExpl[$x].'/';
            if (!file_exists($path)){
                mkdir($path, $permission);
            }
        }        
	}
}
?>