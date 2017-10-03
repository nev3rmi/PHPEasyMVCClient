<?php
namespace PHPEasy\Cores;
use PHPEasy\Cores as Cores;
use PHPEasy\Models as Models;
use PHPEasy\Controllers as Controllers;
// TODO: Refactor code in bootstrap, make sure file request exist, class exist, method exist before require
class _Bootstrap{

	private $_url = null;
	private $_controller = null;

	private $_controllerPath = _Setting::_controllerPath;
	private $_modelPath = _Setting::_modelPath;
	
	private $_errorFile = _Setting::_errorFile;
	private $_errorClass = _Setting::_errorClass;
	private $_errorMethod = _Setting::_errorMethod;

	private $_defaultFile = _Setting::_defaultFile;
	private $_defaultClass = _Setting::_defaultClass;
	private $_defaultMethod = _Setting::_defaultMethod;

	private function SetupInitV1(){
		// Start Here
		$url = isset($_GET['url']) ? $_GET['url'] : null;
		$url = rtrim($url, '/');
		$url = filter_var($url, FILTER_SANITIZE_URL);
		$url = explode('/',$_GET['url']);
		$totalUrl = count($url);
		
		// print_r($url);
		
		if (empty($url[0])){
			require_once 'controllers/index/index.php';
			$controller = new Controllers\Index();
			$controller->Index();
			return false;
		}
		
		$file = 'controllers/'.$url[0].'/'.$url[0].'.php';
		if (file_exists($file)){
			require_once('controllers/'.$url[0].'/'.$url[0].'.php');
		}else{
			require_once 'controllers/error/error.php';
			$controller = new Controllers\Error();
			$controller->Error404();
			return false;
		}
	

		// Initital Class
		$controller = new $url[0];
		// Auto load model
		$controller->loadModel($url[0].'/'.$url[0]);
		
		$parameter = array();
		for($x = 2; $x < $totalUrl; $x++){
			if (preg_match(_Setting::_regexUrl, $url[$x])){
				$inputParam = explode('=', $url[$x]);
				if (!empty($inputParam[1])){
					$parameter[$inputParam[0]] = $inputParam[1];
				}else{
					array_push($parameter, $url[$x]);
				}					
			}else{
				require_once 'controllers/error/error.php';
				$controller = new Error();
				$controller->Error404();
				return false;
				exit();
			}
		}	
			
		if (isset($url[2]) || $totalUrl >= 2){
			if (method_exists($controller, $url[1])){
				$controller->{$url[1]}($parameter);
			}else{
				$this -> Error(400);
			}
		}else{
			if (isset($url[1])){
				$controller->{$url[1]}();
			}else{
				$controller->Index();	
			}
		}

	}

	private function SetupInitV2(){
		$this -> _GetUrl();

		if (empty($this -> _url[0])){
			$this -> _LoadDefaultController();
			return false;
		}
		
		$this -> _LoadExistingController();
		$this -> _CallControllerMethod();
	}

	function __construct(){
		$this -> SetupInitV2();
	}

	private function _GetUrl(){
		$url = isset($_GET['url']) ? $_GET['url'] : null;
		$url = rtrim($url, '/');
		$url = filter_var($url, FILTER_SANITIZE_URL);
		$this -> _url = explode('/', $url);
	}

	private function _LoadExistingController(){
		$class = $this -> _url[0];
		$file = $this -> _controllerPath . $class . '/' . $class . '.php';
		if (file_exists($file)){
			require_once $file;
			$classname = 'PHPEasy\Controllers\\'.$class;
			$this -> _controller = new $classname();
			$this -> _controller -> LoadModel($class.'/'.$class, $this -> _modelPath);
		}else{
			$this -> _Error(404);
			return false;
		}
	}

	private function _LoadDefaultController(){
		require_once $this -> _controllerPath . $this -> _defaultFile . '.php';
		$class = $this -> _defaultClass;
		$classname = 'PHPEasy\Controllers\\'.$class;
		$this -> _controller = new $classname();
		$method = $this -> _defaultMethod;
		$this -> _controller -> $method();
	}

	private function _CallControllerMethod(){
		$totalUrl = count($this -> _url);
		$parameter = array();
		for($x = 2; $x < $totalUrl; $x++){
			if (preg_match(_Setting::_regexUrl, $this -> _url[$x])){
				$inputParam = explode('=', $this -> _url[$x]);
				if (!in_array($inputParam[0], _Setting::_defaultSpecialRoutedKey())){
					if (!preg_match(_Setting::_regexGerneral64, $this -> _url[$x])){
						goto RouteError;
					}
				}
				if (!empty($inputParam[1])){
					$parameter[$inputParam[0]] = $inputParam[1];
				}else{
					array_push($parameter, $this -> _url[$x]);
				}					
			}else{
				RouteError:
				$this -> _Error(404);
				return false;
			}
		}
	
		$method = $this -> _url[1];

		if (!isset($method)){
			$method = $this -> _defaultMethod;
		}

		if (method_exists($this -> _controller, $method)){
			$this -> _controller -> {$method}($parameter);
		}else{
			$this -> _Error(404);
			return false;
		}		
	}


	private function _Error($errorName = 404){
		require_once $this -> _controllerPath . $this -> _errorFile . '.php';
		$class = $this -> _errorClass;
		$classname = 'PHPEasy\Controllers\\'.$class;
		$this -> _controller = new $classname();
		$method = Error.$errorName;
		$this -> _controller->$method();
		exit();
	}
}
?>