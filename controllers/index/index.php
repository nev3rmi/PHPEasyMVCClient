<?php
namespace PHPEasy\Controllers;
use PHPEasy\Cores as Cores;

class Index extends Cores\_Controller{
	
	function __construct(){
		parent::__construct();
	}
	
	function Index(){
		$this -> view -> title = 'Index';
		$this -> view -> render ('index/index');
	}

	function Other(){
		$this -> view -> title = 'Other Index';
		$this -> view -> render ('index/other');
	}
}
?>