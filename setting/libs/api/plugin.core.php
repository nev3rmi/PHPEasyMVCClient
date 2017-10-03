<?php
namespace PHPEasy\Cores;
class _Plugin{
    // TODO: In future will need to put namespace to the api so it will not conflict with another
    public $namespace = null;
    public $locate = null;
    public $apiClass = null;

    private $_currentSiteClass = null; 
    private $_newSiteClass = null;

    function __construct($locate){
        $this -> Set($locate);
        $this -> LoadApi();
        $this -> GetClass();
        $this -> CheckClashClass();
    }
    private function Set($locate){
        $this -> locate = _Site::GetRoot()._Setting::_defaultApiDirectory.'/'.$locate.'.php';
        $this -> _currentSiteClass = _Site::GetClass();
    }

    private function LoadApi(){
        if (file_exists($this -> locate)){
            require_once($this -> locate);
        }else{
            throw new \Exception('The API location is not exist');
        }
    }

    private function GetClass(){
        $this -> _newSiteClass = _Site::GetClass();
        $newClass = array_diff($this -> _newSiteClass, $this -> _currentSiteClass);
        $this -> apiClass = $newClass;
    }

    private function CheckClashClass(){
        if(count(array_unique($this -> _newSiteClass))<count($this -> _newSiteClass))
        {
            $withoutDuplicates = array_unique(array_map("strtoupper", $this -> _newSiteClass));
            $duplicates = array_diff($this -> _newSiteClass, $withoutDuplicates);

            $duplicatesClass = implode(', ', $duplicates);

            throw new \Exception('The API Has Conflict Class: '.$duplicatesClass.' ');
        }
        return true;
    }
}
?>