<?php
namespace PHPEasy\Controllers\Admin;
use PHPEasy\Cores as Cores;
use PHPEasy\Controllers as Controllers;

class TWBSColor extends Controllers\Admin{
    function __construct(){
		parent::__construct();
	}

    function Index($param){
        $this -> twbscolor($param);
    }

    function twbscolor($param){
        $this -> view -> title = 'TWBSColor | Tasks | Admin Dashboard';
        $this -> view -> render ('admin/twbscolor','admin/_layout/_head','admin/_layout/_body');
    }
}