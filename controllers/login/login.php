<?php
namespace PHPEasy\Controllers;
use PHPEasy\Cores as Cores;

class Login extends Cores\_Controller{
	
	function __construct(){
		parent::__construct();
	}
	
	function Index($param){
		$loggedUser = Cores\_Session::Get('loggedUser');
		if (!empty($loggedUser) && $loggedUser -> id !== 1){
			header('Location: /dashboard');
		}else{
			$this -> ShowLogInForm();
		}
	}

	function Register($param){
		$loggedUser = Cores\_Session::Get('loggedUser');
		if (!empty($loggedUser) && $loggedUser -> id !== 1){
			header('Location: /dashboard');
		}else{
			$this -> ShowRegisterForm();
		}
	}

	function Logout(){ // Ajax Run
        Cores\_Session::Destroy("loggedUser");
        exit;
    }

	private function ShowLogInForm(){
		$this -> view -> title = 'Login';
		$this -> view -> render ('login/index');
	}

	private function ShowRegisterForm(){
		$this -> view -> title = 'Register';
		$this -> view -> render ('login/register');
	}

	function Route($param){
		$model = array(
			'../ModelName' => 'partial/route', 
			'ModelPath' => 'models/login/', // Always has last slash models/test (/) <- Important
			'ModelNameSpace' => '\\Login'
		);
		$this -> LoadPartialController($param, 'controllers/login/partial/route', __METHOD__, $model);
	}
}
?>