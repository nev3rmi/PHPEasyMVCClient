<?php
namespace PHPEasy\Controllers\Admin;
use PHPEasy\Cores as Cores;
use PHPEasy\Controllers as Controllers;

class DrawIo extends Controllers\Admin{
    function __construct(){
		parent::__construct();
	}

    function Index($param){
        $this -> ShowDrawIo($param);
    }

    function ShowDrawIo($param){
         // Render
        // if (!empty($param)){
        //     $apiKey = Cores\_Security::DecryptObject($param);
        // }
        // echo Cores\_Security::EncryptObject($param);
        print_r($param);
        $this -> view -> title = 'Draw.IO | Sitemap | Admin Dashboard';
        $this -> view -> key = $apiKey['key']; 
        $this -> view -> render ('admin/drawio','admin/_layout/_head','admin/_layout/_body');
    }
}