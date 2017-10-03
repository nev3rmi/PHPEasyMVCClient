<?php
namespace PHPEasy\Models\Admin;
use PHPEasy\Cores as Cores;
use PHPEasy\Models as Models;

class Dashboard extends Models\Admin{
	function blah1(){
		return 10 + 30;
	}

	function TestDBConnection(){
		return $this -> db -> IsDbConnected();
	}
}
?>