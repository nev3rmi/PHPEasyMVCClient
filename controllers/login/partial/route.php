<?php
namespace PHPEasy\Controllers\Login;
use PHPEasy\Cores as Cores;
use PHPEasy\Controllers as Controllers;

class Route extends Controllers\Login{
    function __construct(){
        parent::__construct();
    }

    function Index($param){ // Work // -> Just check: All Index need to have $param
        $this -> view -> Content('Work');
    }

    function Oauth($param){
        $model = array(
			'../ModelName' => 'oauth/oauth', 
			'ModelPath' => 'models/login/partial/', // Always has last slash models/test (/) <- Important
			'ModelNameSpace' => '\\Login\\Route'
		);
        $this -> LoadPartialController($param, 'controllers/login/partial/oauth/oauth', __METHOD__, $model);
    }

    function viaWebsite($param){
        $model = array(
			'../ModelName' => 'site/viaWebsite', 
			'ModelPath' => 'models/login/partial/', // Always has last slash models/test (/) <- Important
			'ModelNameSpace' => '\\Login\\Route'
		);
        $this -> LoadPartialController($param, 'controllers/login/partial/site/viaWebsite', __METHOD__, $model);
    }
}

?>