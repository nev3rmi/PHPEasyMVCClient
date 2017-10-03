<?php
namespace PHPEasy\Models;
use PHPEasy\Cores as Cores;

class Test extends Cores\_Model{
	function __construct(){
		parent::__construct();
	}
	function blah(){
		return 10 + 10;
	}
}
?>