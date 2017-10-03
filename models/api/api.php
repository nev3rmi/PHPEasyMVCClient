<?php
namespace PHPEasy\Models;
use PHPEasy\Cores as Cores;

class Api extends Cores\_Model{
	function blah1(){
		return 10 + 30;
	}

	function TestDBConnection(){
		return $this -> db -> IsDbConnected();
	}
}
?>