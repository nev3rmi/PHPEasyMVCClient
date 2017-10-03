<?php
namespace PHPEasy\Models\Test;
use PHPEasy\Cores as Cores;
use PHPEasy\Models as Models;

class Test extends Route{
	function blah2(){
		return 30 + 40;
	}

	function TestDBConnection(){
		return $this -> db -> IsDbConnected();
	}
}
?>