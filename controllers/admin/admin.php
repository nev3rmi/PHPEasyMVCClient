<?php
namespace PHPEasy\Controllers;
use PHPEasy\Cores as Cores;

class Admin extends Cores\_Controller{
    function __construct(){
		parent::__construct();
	}

    function Index($param){
        // Init Index
        $this -> Dashboard($param);
    }

    function Dashboard($param){
        $model = array(
			'../ModelName' => 'partial/dashboard', 
			'ModelPath' => 'models/admin/', // Always has last slash models/test (/) <- Important
			'ModelNameSpace' => '\\Admin'
		);
		$this -> LoadPartialController($param, 'controllers/admin/partial/dashboard', 'PHPEasy\Controllers\Admin::Dashboard', $model);
    }

    function Controller($param){
        $model = array(
			'../ModelName' => 'sitemap/controller', 
			'ModelPath' => 'models/admin/partial/', // Always has last slash models/test (/) <- Important
			'ModelNameSpace' => '\\Admin'
		);
		$this -> LoadPartialController($param, 'controllers/admin/partial/sitemap/controller', __METHOD__, $model);
    }

	function Page($param){
		$model = array(
			'../ModelName' => 'sitemap/page', 
			'ModelPath' => 'models/admin/partial/', // Always has last slash models/test (/) <- Important
			'ModelNameSpace' => '\\Admin'
		);
		$this -> LoadPartialController($param, 'controllers/admin/partial/sitemap/page', __METHOD__, $model);
	}

	function Group($param){
		$model = array(
			'../ModelName' => 'user/group', 
			'ModelPath' => 'models/admin/partial/', // Always has last slash models/test (/) <- Important
			'ModelNameSpace' => '\\Admin'
		);
		$this -> LoadPartialController($param, 'controllers/admin/partial/user/group', __METHOD__, $model);
	}

	function User($param){
		$model = array(
			'../ModelName' => 'user/user', 
			'ModelPath' => 'models/admin/partial/', // Always has last slash models/test (/) <- Important
			'ModelNameSpace' => '\\Admin'
		);
		$this -> LoadPartialController($param, 'controllers/admin/partial/user/user', __METHOD__, $model);
	}

	function DrawIo($param){
		$model = array(
			'../ModelName' => 'task/drawio', 
			'ModelPath' => 'models/admin/partial/', // Always has last slash models/test (/) <- Important
			'ModelNameSpace' => '\\Admin'
		);
		$this -> LoadPartialController($param, 'controllers/admin/partial/task/drawio', __METHOD__, $model);
	}
	function TaskManager($param){
		$model = array(
			'../ModelName' => 'task/taskmanager', 
			'ModelPath' => 'models/admin/partial/', // Always has last slash models/test (/) <- Important
			'ModelNameSpace' => '\\Admin'
		);
		$this -> LoadPartialController($param, 'controllers/admin/partial/task/taskmanager', __METHOD__, $model);
	}
	function Update($param){
		$model = array(
			'../ModelName' => 'system/update', 
			'ModelPath' => 'models/admin/partial/', // Always has last slash models/test (/) <- Important
			'ModelNameSpace' => '\\Admin'
		);
		$this -> LoadPartialController($param, 'controllers/admin/partial/system/update', __METHOD__, $model);
	}

	function Filemanager(){
		$model = array(
			'../ModelName' => 'system/filemanager', 
			'ModelPath' => 'models/admin/partial/', // Always has last slash models/test (/) <- Important
			'ModelNameSpace' => '\\Admin'
		);
		$this -> LoadPartialController($param, 'controllers/admin/partial/system/filemanager', __METHOD__, $model);
	}

	function TWBSColor($param){
		$model = array(
			'../ModelName' => 'task/twbscolor', 
			'ModelPath' => 'models/admin/partial/', // Always has last slash models/test (/) <- Important
			'ModelNameSpace' => '\\Admin'
		);
		$this -> LoadPartialController($param, 'controllers/admin/partial/task/twbscolor', __METHOD__, $model);
	}
} 
?>