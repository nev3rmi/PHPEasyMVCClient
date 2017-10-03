<?php
namespace PHPEasy\Models\Test;
use PHPEasy\Cores as Cores;
use PHPEasy\Models as Models;

class Route extends Models\Test{
	function blah1(){
		return 10 + 30;
	}

	function TestDBConnection(){
		return $this -> db -> IsDbConnected();
	}
}
?>