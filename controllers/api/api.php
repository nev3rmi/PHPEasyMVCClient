<?php
namespace PHPEasy\Controllers;
use PHPEasy\Cores as Cores;

class Api extends Cores\_Controller{
    function __construct(){
		parent::__construct();
	}

    function Version($param){
        $model = array(
			'../ModelName' => 'version/version', 
			'ModelPath' => 'models/api/', // Always has last slash models/test (/) <- Important
			'ModelNameSpace' => '\\Api'
		);
		$this -> LoadPartialController($param, 'controllers/api/version/version', __METHOD__, $model);
    }

	function License($param){
        $model = array(
			'../ModelName' => 'license/license', 
			'ModelPath' => 'models/api/', // Always has last slash models/test (/) <- Important
			'ModelNameSpace' => '\\Api'
		);
		$this -> LoadPartialController($param, 'controllers/api/license/license', __METHOD__, $model);
    }
}