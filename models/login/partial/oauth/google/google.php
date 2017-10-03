<?php
namespace PHPEasy\Models\Login\Route\Oauth;
use PHPEasy\Cores as Cores;
use PHPEasy\Models as Models;

class Google extends Models\Login\Route\Oauth{
    function __construct(){
		parent::__construct();
	}

	function ProcessSignIn($data){
		return $this -> RunUserLogin($data);
	}
}