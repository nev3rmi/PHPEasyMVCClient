<?php
namespace PHPEasy\Controllers;
use PHPEasy\Cores as Cores;

class Robots extends Cores\_Controller{
    function __construct(){
		parent::__construct();
	}

    function Index(){
        $this -> view -> render('robots/index', null, null, true, true);
    }
}