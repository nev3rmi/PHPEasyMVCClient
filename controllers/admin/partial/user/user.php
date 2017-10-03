<?php
namespace PHPEasy\Controllers\Admin;
use PHPEasy\Cores as Cores;
use PHPEasy\Controllers as Controllers;

class User extends Controllers\Admin{
    function __construct(){
		parent::__construct();
	}

    function Index($param){
        $this -> GetUser();
    }

    function GetUser(){
        // Render
        $this -> view -> title = 'Users | User | Admin Dashboard';
		$this -> view -> render ('admin/user','admin/_layout/_head','admin/_layout/_body');
    }

    function GetDataForUserTable(){
        $data = $this -> model -> GetUser();
        $this -> view -> content(json_encode($data));
    }
}