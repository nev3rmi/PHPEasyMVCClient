<?php
namespace PHPEasy\Controllers;
use PHPEasy\Cores as Cores;

class Dashboard extends Cores\_Controller{
    function __construct(){
		parent::__construct();
	}
	
	function Index(){
		// TODO: Build in CMS
		$this -> view -> title = 'Dashboard';
		$this -> view -> render ('dashboard/index');
	}

    function xhrInsert(){
        $this -> model -> Test();
    }
}
?>