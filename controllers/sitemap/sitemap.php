<?php
namespace PHPEasy\Controllers;
use PHPEasy\Cores as Cores;

class Sitemap extends Cores\_Controller{
	
	function __construct(){
		parent::__construct();
	}

    function Index(){
        $this -> view -> data -> sitemap = $this -> model -> CreateSitemap();
        $this -> view -> render('sitemap/index', null, null, true, true);
    }
}
