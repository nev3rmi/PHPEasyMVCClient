<?php
// NOT WORK
namespace PHPEasy\Models\Test\Route;
use PHPEasy\Cores as Cores;
use PHPEasy\Models as Models;

class Test extends Route{
	function blah4(){
		return 130 + 40;
	}

	function TestDBConnection(){
		return $this -> db -> IsDbConnected();
	}
}
?>