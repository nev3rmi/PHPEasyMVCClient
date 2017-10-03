<?php
namespace PHPEasy\Controllers\Admin;
use PHPEasy\Cores as Cores;
use PHPEasy\Controllers as Controllers;

class Filemanager extends Controllers\Admin{
    function __construct(){
		parent::__construct();
	}
    function Index($param){
        $this -> MainPage($param);
    }

    private function MainPage($param){
        // Render
        $this -> view -> title = 'File Manager | System | Admin Dashboard';
		$this -> view -> render ('admin/filemanager','admin/_layout/_head','admin/_layout/_body');
    }
}

?>