<?php
namespace PHPEasy\Controllers;
use PHPEasy\Cores as Cores;

class Error extends Cores\_Controller{
	function __construct(){
		parent::__construct();
	}

	function Error400(){
		$this -> view -> title = '400 | Error';
		$this -> view -> render('error/400');
	}

	function Error401(){
		$this -> view -> title = '401 | Error';
		$this -> view -> render('error/401');
	}

	function Error403(){
		$this -> view -> title = '403 | Error';
		$this -> view -> render('error/403');
	}

	function Error404(){
		if ($this -> page -> pageContent === null){
			$this -> view -> title = '404 | Error';
			$this -> view -> render('error/404');
		}else{
			// implement model later :)
			$this -> view -> render('cms/view');
		}
	}

	function Error500(){
		$this -> view -> title = '500 | Error';
		$this -> view -> render('error/500');
	}
}
?>