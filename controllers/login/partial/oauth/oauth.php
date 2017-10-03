<?php
namespace PHPEasy\Controllers\Login\Route;
use PHPEasy\Cores as Cores;
use PHPEasy\Controllers as Controllers;

class Oauth extends Controllers\Login\Route{
    function __construct(){
        parent::__construct();
    }

    function Index($param){ // Work // -> Just check: All Index need to have $param
        $this -> view -> Content('Work');
    }

    function Google($param){
        $model = array(
			'../ModelName' => 'google/google', 
			'ModelPath' => 'models/login/partial/oauth/', // Always has last slash models/test (/) <- Important
			'ModelNameSpace' => '\\Login\\Route\\Oauth'
		);
        $this -> LoadPartialController($param, 'controllers/login/partial/oauth/google/google', __METHOD__, $model);
    }

    function Facebook($param){
        $model = array(
			'../ModelName' => 'facebook/facebook', 
			'ModelPath' => 'models/login/partial/oauth/', // Always has last slash models/test (/) <- Important
			'ModelNameSpace' => '\\Login\\Route\\Oauth'
		);
        $this -> LoadPartialController($param, 'controllers/login/partial/oauth/facebook/facebook', __METHOD__, $model);
    }
}

