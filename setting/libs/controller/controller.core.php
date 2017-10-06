<?php
namespace PHPEasy\Cores;

abstract class _Controller{
	
	protected $_partialController = null;
	
	function __construct(){
		$this->view = new _View;
		$this->system = new _System;
		if ((new _Database) -> IsDbConnected()){
			$this->user = new _User;
			$this->page = new _Page;
			$this->auth = new _Auth;
			
			// View
				$this -> UpdateView();
			// CMS
				// Short Code
				$this -> view -> cms -> content -> shortcode = array(
					'*|UserEmail|*' => $this -> user -> email,
					'*|UserId|*' => $this -> user -> id,
					'*|UserFName|*' => $this -> user -> firstname,
					'*|UserLName|*' => $this -> user -> lastname,
					'*|UserAvatar|*' => $this -> user -> avatar,
					'*|UserIp|*' => $this -> user -> ip
				);
				$this -> UpdateCMS();
		}

		// Test
		// $loggedUser = _Session::Get('loggedUser');
		// print_r($loggedUser);
		// echo '<br>';
		// $page = _Session::Get('page');
		// print_r($page);
		// echo '<br>';
		// echo $page -> permission -> Get(_Permission::Read);
		// $system = _Session::Get('system');
		// print_r($system);
		// echo '<br>';
		// $sitemap = _Session::Get('sitemap');
		// print_r($sitemap);
		// echo '<br>';
	}	

	function UpdateView(){
		// Auto Title
		$this -> view -> title = $this -> page -> pageName;
		// Auto Meta
		if (!empty($this -> page -> pageDescription)){
			$this->view->meta[] = 'name="description" content="'. $this -> page -> pageDescription.'"';
			$this->view->meta[] = 'property="og:description" content="'. $this -> page -> pageDescription.'"';
		}
		if (!empty($GLOBALS['_Site'] -> GetFullUrlNoParam())){
			$this->view->meta[] = 'property="og:url" content="'. $GLOBALS['_Site'] -> GetFullUrlNoParam().'"'; 
		}
		if (!empty($this -> page -> pageName)){
			$this->view->meta[] = 'property="og:title" content="'. $this -> page -> pageName.'"';
		}
		if (!empty($this -> page -> pageAuthor)){
			$this->view->meta[] = 'property="article:author" content="'. $this -> page -> pageAuthor.'"';
		}
		if (!empty($this -> page -> pagePublishedDate)){
			$this->view->meta[] = 'property="article:published_time" content="'. $this -> page -> pagePublishedDate.'"';
		}
		$this->view->meta[] = 'property="og:type" content="website"';

		// Config Page
			// Navbar
			$this->view->navbar->IsHide = $this->page->pageHideNavBar;
			// Config
			$this->view->navbar->config = $this->page->pageNavbarConfig;
			$this->view->navbar->transparent = $this->page->pageTransparentNavbar;

			// Footer
			$this->view->footer->IsHide = $this->page->pageHideFooter;
			
	}

	function UpdateCMS($shortCode = array()){
		$_shortcode = $GLOBALS['_ShortCode'];

		if (!empty($shortCode)){
			$_shortcode = array_merge($_shortcode, $shortCode);
		}

		if (!empty($this -> view -> cms -> content -> shortcode)){
			$_shortcode = array_merge($_shortcode, $this -> view -> cms -> content -> shortcode);
		}
		
		$this -> view -> cms -> content -> code = str_replace(array_keys($_shortcode), array_values($_shortcode), html_entity_decode ($this -> page -> pageContent));
	
		return $_shortcode;
	}
	/**
	*	
	*/
	function LoadModel($name, $modelPath = 'models/', $namespace = null){
		try{
			$loadResult = null;
			$path = _Site::GetRoot() . $modelPath . $name . '.php';
			if (file_exists($path)){
				require_once($path);
				$modelNameExpl = explode('/',$name);
				$modelName = (!empty($modelNameExpl[1]))?$modelNameExpl[1]:$modelNameExpl[0];
				if (empty($this -> model) && $namespace !== null){ // Load default model and namespace is not null
					$namespaceExpl = explode('\\', $namespace);
					array_shift($namespaceExpl);
					foreach ($namespaceExpl as $namespaceResult){
						$namePart .= '_'.$namespaceResult;
						$namespacePart .= $namespaceResult.'\\'; 
					}
					$modelName = 'PHPEasy\Models\\'.$namespacePart.($nameExpl[1] !== null ? $nameExpl[1].'\\' : '').$modelName;
					$namePart = model;
					$this -> model = new $modelName();
				}elseif (empty($this -> model)){ // Load default model
					$modelName = 'PHPEasy\Models\\'.$modelName;
					$namePart = model;
					$this -> model = new $modelName();
				}elseif ($namespace !== null){
					$namespaceExpl = explode('\\', $namespace);
					array_shift($namespaceExpl);
					foreach ($namespaceExpl as $namespaceResult){
						$namePart .= '_'.$namespaceResult;
						$namespacePart .= $namespaceResult.'\\'; 
					}
					$namePart = $modelName.$namePart.'_'.model;
					$nameExpl = explode('_', $name);
					$modelName = 'PHPEasy\Models\\'.$namespacePart.($nameExpl[1] !== null ? $nameExpl[1].'\\' : '').$modelName;
					$this -> $namePart = new $modelName();
				}else{
					$namePart = $modelName.'_'.model;
					$nameExpl = explode('_', $name);
					$modelName = 'PHPEasy\Models\\'.($nameExpl[1] !== null ? $nameExpl[1].'\\' : '').$modelName;
					$this -> $namePart = new $modelName();
				}
				$loadResult = $namePart;
			}else{
				throw new \Exception ('Model Not Found!');
			}
		}catch (\Exception $e){
			$loadResult = $e -> GetMessage();
		}finally{
			return $loadResult;
		}
	}
	
	// TODO: Work on route > 4th level
	/*
		Theory -> Model Extends only around 1st or 2nd level extends no more than that.
	*/
	// Due to max user connection to Db is allow 3 -> You can only route to 3 level, in the level 4 you cannot use multiple Model.
	// But if you want to use more, the extend of model need to be in first and second level, then you can use 1 more.
	// Check controller/test to get more information

	// Bug cannot load further than 4th or sth wrong.
	function LoadPartialController($params, $partialPath, $parentMethod = __METHOD__, $infoToLoadModel = array('../ModelName' => 'partial/route', 'ModelPath' => 'models/test/partial/', 'ModelNameSpace' => '\\Test\\Route'), $level = 0){
		$parentMethod = explode('\\', $parentMethod);
		$endParentMethod = end($parentMethod);
		$endParentMethodToArray[] = $endParentMethod;
		$frontParentMethod = array_diff($parentMethod, $endParentMethodToArray);
		$frontParentMethodToString = implode('\\',$frontParentMethod);
		$classExpl = explode('::', $endParentMethod);//'\n' "\n"
		for ($x = 0; $x <= $level; $x++){
			if (empty($params[0])){
				$params[0] = 'index';
			}
			$path = $partialPath.'.php';
			// var_dump($path);
			if (file_exists($path)){
				
				require_once $path;

				$namespace = $frontParentMethodToString.'\\'.$classExpl[0];
				if (!empty($classExpl[1])){
					$classname = $namespace.'\\'.$classExpl[1];
				}else{
					$classname = $namespace;
				}
				
				// Init Class
				$this -> _partialController = new $classname;
				// Auto Clean Model
				$this -> model = null;
				// Auto Load new model
				$loadModelResult = $this -> LoadModel($infoToLoadModel['../ModelName'], $infoToLoadModel['ModelPath'], $infoToLoadModel['ModelNameSpace']);
				// Init model for class				
				$this -> _partialController -> model = $this -> model;	
				// Auto Clean Model
				$this -> model = null;

				if (method_exists($this -> _partialController, $params[0])){
					$newparams = $params;
					array_shift($newparams);
					$this -> _partialController -> {$params[0]}($newparams);
				}else{
					header('Location: /error/error404');
					return false;
				}

				return 'Class '. $classname .' Load Successful, Model Load Result: '. $loadModelResult;
			}
		}
	}
}
?>