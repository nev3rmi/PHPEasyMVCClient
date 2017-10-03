<?php
namespace PHPEasy\Models\Test\Route;
use PHPEasy\Cores as Cores;
use PHPEasy\Models as Models;
use PHPEasy\Models\Test as ModelsTest;

class Route extends ModelsTest\Route{
	function blah3(){
		return 60 + 30;
	}

	function TestDBConnection(){
		return $this -> db -> IsDbConnected();
	}
}
?>