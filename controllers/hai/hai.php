<?php
namespace PHPEasy\Controllers;
use PHPEasy\Cores as Cores;

class Hai extends Cores\_Controller{
	public function Index(){
		//$this -> view -> content("Test");
		print_r($param);
	}

	// function Route($param){ // Don't forget to put $param in otherwise will not work <- Important
	// 	$this -> LoadPartialController($param, 'controllers/test/partial/route');
	// }

	function Route($param){ // Model Not Work, Need to fix max_user_connection first before route more
		// Gan nhu la cai function nay no chi load dc may cai cung folder  @@? ong check thu xem
		// Check coi no load model cross dc ko ?

        // $model = array(
		// 	'../ModelName' => 'test/test', 
		// 	'ModelPath' => 'models/', // Always has last slash models/test (/) <- Important
		// 	'ModelNameSpace' => '' 
		// );
		// $this -> LoadPartialController($param, 'controllers/test/test', 'PHPEasy\\Controllers\\Test', $model);
		// echo 1;
		// echo $this -> LoadModel('test/test'); //-> Cai nay ko chay thi phai
		// $this -> view -> content("Test");
		$contentWiki = "1. Sử dụng Model trong Controller
		Có 2 cách để load Model ở trong controller.
			- LoadModel
			- LoadPartialController";   
		$this -> view -> cms -> content -> shortcode['*|Wiki|*'] = $contentWiki;
		$this -> UpdateCMS();
		$this -> view -> content($this -> view -> cms -> content -> code);
    }

	
}