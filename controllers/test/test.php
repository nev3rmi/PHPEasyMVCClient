<?php
namespace PHPEasy\Controllers;
use PHPEasy\Cores as Cores;

class Test extends Cores\_Controller{

	function __construct(){
		parent::__construct();
	}

	function Index(){
		$this -> view -> Content('Test');
	}
	
	function Route($param){ // Don't forget to put $param in otherwise will not work <- Important
		$model = array(
			'../ModelName' => 'partial/route', 
			'ModelPath' => 'models/test/', // Always has last slash models/test (/) <- Important
			'ModelNameSpace' => '\\Test'
		);
		$this -> LoadPartialController($param, 'controllers/test/partial/route', __METHOD__, $model);
	}

	function TestModel(){
		$value = $this -> model -> blah();
		$this -> view -> content($value);
	}

	function testParameter($test = null){
		$page = Cores\_Session::Get('page');
		print_r($page);
		print_r($test);
	}
	
	function testNonParameter(){
		print_r($test);
	}
	function email(){ // Not work yet !!@!!
		// If use new shortcode
		// $GLOBALS[_ShortCode] = "" // Global short code use for plugin
		// $this -> view -> cms -> content -> shortcode['*|OkMan|*'] = "Ok Man"; // Inline Short code
		// $this -> UpdateCMS(array('*|TestMe|*' => "TestMeasdasdasd")); // Inline Short code, must run this line to update shortcode

		$this -> view -> cms -> content -> shortcode['*|LinkActiveAccount|*'] = "Ok Man";

		$GLOBALS['_Email'] ->setFrom($GLOBALS['_Email'] -> Storage -> Address -> Bot, 'BOT');
		$GLOBALS['_Email'] ->addAddress('nev3rmi@gmail.com');     // Add a recipient
		// $GLOBALS['_Email'] -> SMTPDebug  = 2;
		$GLOBALS['_Email'] ->IsHTML(true);                                  // Set email format to HTML
		$GLOBALS['_Email'] ->Subject = 'Here is the subject';
		$GLOBALS['_Email'] ->Body    = $GLOBALS['_Email'] ->SetTemplate('/email/template/default/verify', $this -> UpdateCMS());
		

		if(!$GLOBALS['_Email'] ->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $GLOBALS['_Email'] ->ErrorInfo;
		} else {
			echo 'Message has been sent';
		}
	}
	function content(){
		// $this -> view -> content = $this -> page -> pageContent;
		$this -> view -> Content($this -> page -> pageContent);
	}

	function testCarousel(){
		$this -> view -> render('test/carousel');
	}

	function testFbPost(){
		$this -> view -> render('test/fbpost');
	}

	function angularJS(){
		$this -> view -> render('test/angularjs');
	}
}
?>