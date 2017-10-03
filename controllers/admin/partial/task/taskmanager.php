<?php
namespace PHPEasy\Controllers\Admin;
use PHPEasy\Cores as Cores;
use PHPEasy\Controllers as Controllers;

class TaskManager extends Controllers\Admin{
    function __construct(){
		parent::__construct();
	}

    function Index($param){
        $this -> ShowTaskManager($param);
    }

    function ShowTaskManager($param){
        $this -> view -> title = 'TaskManager | Sitemap | Admin Dashboard';
        $this -> view -> render ('admin/taskmanager','admin/_layout/_head','admin/_layout/_body');
    }
}
