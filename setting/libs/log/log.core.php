<?php
namespace PHPEasy\Cores;
class _Log{
    protected $logDirectory = null;
    protected $namespace = null;
    protected $controller = null;
    protected $controllerPath = null;
    protected $method = null;
    protected $methodPath = null;
    protected $fileName = null;
    protected $filePath = null;

    public function __construct($namespace, $controller, $method){
        $this -> logDirectory = _Site::GetRoot()._Setting::_defaultLogDirectory;
        $this -> SetProperty($namespace, $controller, $method);
    }

    private function SetProperty($namespace, $controller, $method){
        $this -> namespace = $namespace; 
        $this -> controller = $controller;
        $this -> method = $method;
        $controllerPath = str_replace('\\', '/', $this -> logDirectory.'/'.$this -> controller);
        $this -> controllerPath = $controllerPath;
        $methodPath = str_replace('\\', '/', $controllerPath.'/'.$this -> method.'/');
        $this -> methodPath = $methodPath;
        $this -> fileName = 'Log-'.date("dmY-H", strtotime($GLOBALS['_NOW_'] -> clockDateTime)).'.log';
        $this -> filePath = $this -> methodPath.$this-> fileName;
    }

    function WriteLog($key, $value = null){
        if (!file_exists($this -> filePath)){
            // Create Folder
            $this -> CreateLogFolder();
            // Create File
            $handle = fopen($this -> filePath, 'w') or die('Cannot open file:  '.$this -> filePath);
            $data = '# '._Security::GetKey('siteName').' '."\n".'# Date Created: '.$GLOBALS['_NOW_'] -> clockDateTime."\n".'# Controller: '.$this -> controller."\n".'# Method: '.$this -> method."\n".'# =============================================== '."\n\n";
            fwrite($handle, $data);
        }
        $handle = fopen($this -> filePath, 'a') or die('Cannot open file:  '.$this -> filePath);
        $new_data = "\n".$GLOBALS['_NOW_'] -> clockDate.' - '.$GLOBALS['_NOW_'] -> clockTime.' ==> '.$key.': '.$value.' - UserId: '._Session::Get('loggedUser') -> id . ' - IP: '._Session::Get('loggedUser') -> ip;
        fwrite($handle, $new_data);
    }

    function GetLog(){
        
    }

    private function CreateLogFolder(){      
        _Folder::CreateFolder($this -> methodPath);
    }

}
?>