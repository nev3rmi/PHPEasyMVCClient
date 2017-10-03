<?php
namespace PHPEasy\Controllers\Api;
use PHPEasy\Cores as Cores;
use PHPEasy\Controllers as Controllers;

class Version extends Controllers\Api{
    function __construct(){
		parent::__construct();
	}

    function Index($param){
        $version = $this -> model -> GetSystemInfo()['version'];
        $this -> view -> content($version);
    }

    function Check($param){ // Remove when give to partner :)
        $this -> view -> render('api/version/log', null, null, true, true);
    }

    function CheckUpdate($param){
        $this -> view -> version -> site = $this -> model -> GetSystemInfo()['version'];
        $this -> view -> version -> server = $this -> model -> GetServerVers();
        $this -> view -> version -> update = $this -> model -> CheckUpdate();
        $this -> view -> version -> list = $this -> model -> GetListUpdate();
        $this -> view -> render('api/version/index', null, null, true, true);
    }

    function DoUpdate(){
        $this -> model -> DoUpdate();
    }
}
?>