<?php
namespace PHPEasy\Controllers\Admin;
use PHPEasy\Cores as Cores;
use PHPEasy\Controllers as Controllers;

class Dashboard extends Controllers\Admin{
    function __construct(){
		parent::__construct();
	}

    function Index($param){
        $this -> view -> title = 'Overview | Admin Dashboard';
		$this -> view -> Render ('admin/index','admin/_layout/_head','admin/_layout/_body');
    }
}
?>