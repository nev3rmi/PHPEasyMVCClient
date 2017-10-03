<?php
namespace PHPEasy\Models\Test\Route;
use PHPEasy\Cores as Cores;
use PHPEasy\Models as Models;
use PHPEasy\Models\Test as ModelsTest;

class testPossible extends ModelsTest\Route{
	function blah4(){
		return 130 + 40;
	}

	function TestDBConnection(){
		return $this -> db -> IsDbConnected();
	}
}
?>