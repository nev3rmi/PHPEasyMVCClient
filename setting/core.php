<?php
namespace PHPEasy\Cores;
class _Core{
	public function __construct() {
		// Change this in the way you want or leaves it as default
		//$this -> root = './'; // For Final release and not include dev -> This to make sure dev folder do not work in final release!
		$this -> root = $_SERVER['DOCUMENT_ROOT'].'/'; 
	}
	
	public function AutoGetCoreFiles($dir = null, $fileSubfixName = 'core.php', $priorArrangeArray = array(), $lowPriorArrangeArray = array(), $absolute = false){
		$messageResult = '';
		try{
			$finalResult = array();
			$getNecessaryFiles = $this -> GetNecessaryFile($dir, $fileSubfixName);
			
			if (is_array($getNecessaryFiles)){
				$finalResult = array_merge($finalResult, $getNecessaryFiles);
			}
			
			$GLOBALS['includedFiles'] = $finalResult;

			spl_autoload_register(function ($class_name) {
				$_getClass = explode("_",$class_name);
				$finalResult = preg_grep('/^.*\.?('. strtolower($_getClass[1].".core.php") .')$/', $GLOBALS['includedFiles']);
				require_once (reset($finalResult));
			});

			// Autoget .custom and put it into low prior file
			$customResult = preg_grep('/^.*\.?(custom.'.$fileSubfixName.')$/',$finalResult);
			foreach ($customResult as $value){
				$value = end(explode('/', $value));
				array_push($lowPriorArrangeArray, $value);
			}

			// Clean up
			$customHoldResult = null;

			// Low Prior File
			if (!empty($lowPriorArrangeArray)){

				$_Array = new _Array();
				$unArrangeArray = array();

				foreach ($finalResult as $value){
					$explodeValue = explode('/',$value);
					array_push($unArrangeArray, end($explodeValue));
				}

				$arrangeResult = $_Array -> LowPriorKeyArrangeByArray($unArrangeArray, $lowPriorArrangeArray);

				$holdingResult = $finalResult;

				$finalResult = array();

				foreach ($arrangeResult as $arrange){
					if ($absolute){
						$getPosition = preg_grep('/^.*\.?('. $arrange .')$/', $holdingResult);
						if (count($getPosition) > 1){
							$arrayFilter = array();
							foreach ($getPosition as $checkAbsolute){
								if (preg_match('/^\b('.$arrange.')\b$/',end(explode('/', $checkAbsolute)))){
									$arrayFilter[] = $checkAbsolute;
								}
							}

							$getPosition = array_intersect($arrayFilter,$getPosition);
						}
					}else{
						$getPosition = preg_grep('/^.*\.?('. $arrange .')$/', $holdingResult);
					}
					$finalResult = array_merge($finalResult, $getPosition);
				}

			}

			// Prior File
			if (!empty($priorArrangeArray)){
				
				$_Array = new _Array();
				$unArrangeArray = array();

				foreach ($finalResult as $value){
					$explodeValue = explode('/',$value);
					array_push($unArrangeArray, end($explodeValue));
				}
				
				$arrangeResult = $_Array -> PriorKeyArrangeByArray($unArrangeArray, $priorArrangeArray);

				$holdingResult = $finalResult;

				$finalResult = array();

				foreach ($arrangeResult as $arrange){
					if ($absolute){
						$getPosition = preg_grep('/^.*\.?('. $arrange .')$/', $holdingResult);
						if (count($getPosition) > 1){
							$arrayFilter = array();
							foreach ($getPosition as $checkAbsolute){
								if (preg_match('/^\b('.$arrange.')\b$/',end(explode('/', $checkAbsolute)))){
									$arrayFilter[] = $checkAbsolute;
								}
							}

							$getPosition = array_intersect($arrayFilter,$getPosition);
						}
					}else{
						$getPosition = preg_grep('/^.*\.?('. $arrange .')$/', $holdingResult);
					}
					$finalResult = array_merge($finalResult, $getPosition);
				}
			}
			 
			// Get File Type
			$explodeFileName = explode('.', $fileSubfixName);
			$filesType = end($explodeFileName);

			// Include File
			$messageResult = $this -> IncludeFiles($finalResult, $filesType);
		}catch (Exception $error){
			$messageResult = $error -> getMessage();
		}
		// Return Array of Result
		return $messageResult;
	}

	private function GetNecessaryFile($dir = null, $fileSubfixName = 'core.php'){
			// Default Directory
			$finalResult = array();
			$dir = ($dir == null) ? $this -> root.'setting' : $dir;
			$preResult = array();
			if (!file_exists($dir)){
				return 'Directory is not exist';
				exit;
			}
			$getAllFileAndFolder = scandir($dir);
			foreach ($getAllFileAndFolder as $fileAndFolder){
				if ($fileAndFolder != '.' && $fileAndFolder != '..'){
					if(is_dir($dir.'/'.$fileAndFolder)){ 
						if (!preg_match('/^ignore$/', $fileAndFolder)){
							array_push($preResult, $this -> GetNecessaryFile($dir.'/'.$fileAndFolder, $fileSubfixName));
						}
					}else{
						array_push($preResult, $dir.'/'.$fileAndFolder);
					}
				}
			}
					
			// Flatten Array
			$preResult = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($preResult));
			$finalResult = array();
			$privateResult = array();
			foreach($preResult as $result) {
			  array_push($finalResult, $result);
			}

			// Get Subfix File Name that wanted
			$finalResult = preg_grep('/^.*\.?('.$fileSubfixName.')$/',$finalResult);
			// Remove All Private Files if not specific include
			$privateResult = preg_grep('/^.*\.?(private.'.$fileSubfixName.')$/',$finalResult);
			$finalResult = array_diff($finalResult, $privateResult);
			// Remove All Ignore Files
			$ignoreResult = preg_grep('/^.*\.?(ignore.'.$fileSubfixName.')$/',$finalResult);
			$finalResult = array_diff($finalResult, $ignoreResult);

			return $finalResult;
	}
	
	private function IncludeFiles($filesArray = null,$filesType = null){
		// Include it
		$filesType = strtolower($filesType);
		if ($filesType == null){
			$filesType = 'php';
		}
		$includeFile = '';
		try{
			foreach ($filesArray as $file){
				$fileExplode = explode(".", $file);
				$fileExtension = end($fileExplode);
				if ($fileExtension == $filesType){
					if ($filesType == 'php')
						{
							require_once($file);
						}
					if ($filesType == 'js')
						{
							$js = $this -> ConvertRootToURL($file);
							echo '<script type="text/javascript" src="'.$js.'"></script>';
						}
					if ($filesType == 'css')
						{
							$css =  $this -> ConvertRootToURL($file);
							echo '<link rel="stylesheet" href="'.$css.'"/>';
						}
					$includeFile .= $file.', ';
				}
			}
		}catch (Exception $error){
			$includeFile = $error -> getMessage();
		}finally{
			return $includeFile;
		}
	}

	private function ConvertRootToURL($rootString){
		$rootString = str_replace($this -> root, _Site::GetUrl(), $rootString);
		return $rootString;
	}

	private function ConvertURLToRoot($urlString){
		$urlString = str_replace(_Site::GetUrl(),$this -> root, $rootString);
		return $urlString;
	}

	public function GetIncludedFiles(){
		return _Ultility::ConsoleData(get_included_files());
	}
	
	public function AutoGetPrivateCoreFiles($folderPath = null, $fileExtension){
		if($folderPath == null){
			$folderPath = _Site::GetDocumentPath();
		}
		// Explode Url
		$urlExpl = explode('/',_Site::GetDocumentPath());
		$getEndUrl = end($urlExpl);
		if (preg_match('/^.*\.?(.php)$/',$getEndUrl)){
			array_pop($urlExpl);
		}
		array_shift($urlExpl);
		$fileType = '';
		$folderExtension = explode('.',$fileExtension);
		foreach ($urlExpl as $path){
			$fileType .= '.'.$path;
			$fileRequire = substr($fileType,1).'.'.$fileExtension;
			$this -> AutoGetCoreFiles($folderPath.'/'.end($folderExtension),$fileRequire);
			if ($path === end($urlExpl)){
				$this -> AutoGetCoreFiles($folderPath.'/'.end($folderExtension),'private.'.$fileRequire);
			}
		}
	}
}