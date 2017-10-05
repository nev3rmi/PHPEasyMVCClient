<?php
namespace PHPEasy\Controllers;
use PHPEasy\Cores as Cores;

class Install extends Cores\_Controller{
	private $info = array();

	function __construct(){
		parent::__construct();
		$this -> Init();
	}

	private function Init(){
		$this -> info['version'] = '1.0.6.5.Beta2';
		$this -> info['serverLink'] = 'http://codeasy.cf/api/version/check';
		$this -> info['serverPackageLink'] = 'http://update.codeasy.cf';
	}

    function Index(){
        $this -> view -> title = 'Install';
        $this -> view -> data -> ip = Cores\_Site::GetClientIP();
		$this -> view -> data -> url = Cores\_Site::GetUrl();
		$this -> view -> info -> version = $this -> info['version'];
        $this -> view -> render('install/index');
    }

	function GetCurrentStep(){
		
		$this -> view -> content(json_encode($this -> model -> GetCurrentStep(), true));
		// $return = array();
		// $return['step'] = 1;
		// $this -> view -> content(json_encode($return['step']));
	}

	function SaveCurrentStep(){
		try{
			$form = new Cores\_Form;
			$form 	-> Post('currentStep')
						-> Validate('Digit')	
					-> Submit();
			$data = $form -> Fetch();
			print_r($data);
			$this -> model -> SaveCurrentStep($data);
		}catch(\Exception $e){
			$this -> view ->  Content ($e -> getMessage()); 
		}
	}

    // function SaveKey(){
	// 	$result = null;
    //     try{
	// 		$form = new Cores\_Form;
	// 		$form 	-> Post('key')
	// 					-> Validate('Regex', Cores\_Setting::_regexGerneral255)	
	// 				-> Submit();
	// 		$data = $form -> Fetch();
	// 		$key = $this -> model -> SaveKey($data);
	// 		$res = $this -> model -> createSystemFile($this -> info);

	// 		if($key['result'] != '101'){
	// 			throw new \Exception ('1'.$key['message']);
	// 		}
			
	// 		if ($res['result'] != '101'){
	// 			throw new \Exception ('2'.$res['message']);
	// 		}
			
	// 		$result = $key;
	// 	}catch(\Exception $e){
	// 		$result = $this -> model -> ObjReturnCode(202, $e -> getMessage());
	// 	}finally{
	// 		$this -> view -> content(json_encode($result));
	// 	}
	// }
	
	function SaveKey(){
		$result = null;
        try{
			$form = new Cores\_Form;
			$form 	-> Post('key')
						-> Validate('Regex', Cores\_Setting::_regexGerneral255)	
					-> Submit();
			$data = $form -> Fetch();
			
			$keys[0] = $this -> model -> SaveKey($data);
			$keys[1] = $this -> model -> CreateSystemFile($this -> info);

			foreach($keys as $key => $value){
				if ($value['result'] != 101){
					throw new \Exception ($value['message']);
				} 
			}

			$result = $this -> model -> ObjReturnCode(101, "Stage 1: Done.");
		}catch(\Exception $e){
			$result = $this -> model -> ObjReturnCode(202, $e -> getMessage());
		}finally{
			$this -> view -> content(json_encode($result));
		}
    }
	
	/**
	 * SaveDb function
	 * 
	 * This function need to do check db connect or not, the password is correct or not :)
	 * @return void
	 */
	function SaveDb(){
		$result = null;
		try{
			$form = new Cores\_Form;
			$form 	-> Post('hostname')
						-> Validate('Regex', Cores\_Setting::_regexDatabase) 
					-> Post('username')
						-> Validate('Regex', Cores\_Setting::_regexDatabase)
					-> Post('password')
						-> Validate('Regex', Cores\_Setting::_regexDatabase)
					-> Post('dbname')
						-> Validate('Regex', Cores\_Setting::_regexDatabase)
					-> Submit();
			$data = $form -> Fetch();
			$result = $this -> model -> SaveDatabase($data);
		}catch(\Exception $e){
			$result = $this -> model -> ObjReturnCode(202, $e -> getMessage());
		}finally{
			$this -> view -> content(json_encode($result));
		}
	}

	function CheckKeyLicenseWithServer(){ // TODO: Hash data before send.
		$result = null;
		try{
			$form = new Cores\_Form;
			$form 	-> Post('ip')
						-> Validate('Regex', Cores\_Setting::_regexIp)
					-> Post('url')
						-> Validate('Regex', Cores\_Setting::_regexFullUrl)
					-> Post('key')
						-> Validate('Regex', Cores\_Setting::_regexGerneral255)	
					-> Submit();
			$data = $form -> Fetch();
			$result = $this -> model -> CheckKeyLicense($data);
		}catch(\Exception $e){
			$result = $this -> model -> ObjReturnCode(202, $e -> getMessage());
		}finally{
			$this -> view -> content(json_encode($result));
		}
	}

	function SaveContentCode(){
		$result = null;
		try{
			$form = new Cores\_Form;
			if (strpos($_POST['googleKey'], '<meta') == 0){
				$exp = explode('content="',$_POST['googleKey']);
				$exp1 = explode('"',$exp[1]);
				$_POST['googleKey'] = $exp1[0];
			}
			$form 	-> Post('siteName')
						-> Validate('Regex', Cores\_Setting::_regexGerneral64)
					-> Post('sitePublisher')
						-> Validate('Regex', Cores\_Setting::_regexGerneral255)
					-> Post('copyrightYear')
						-> Validate('Regex', Cores\_Setting::_regexGerneral)
					-> Post('siteEmail')
						-> Validate('Regex', Cores\_Setting::_regexMail)
					-> Post('siteContact')
						-> Validate('Regex', Cores\_Setting::_regexPhoneNumber)
					-> Post('siteAddress')
						-> Validate('Regex', Cores\_Setting::_regexGerneral255)
					-> Post('googleKey')
						-> Validate('Regex', Cores\_Setting::_regexGerneral64)
					-> Post('description')
						-> Validate('Regex', Cores\_Setting::_regexGerneral255);
					

			if ($_POST['fanpage'] == null){
				$form 	-> Post('googleKey')
				-> Validate('Regex', Cores\_Setting::_regexGerneral64);
				
			}

			$form -> Submit();
			$data = $form -> Fetch();
			
			$result = $this -> model -> SaveGoogleKey($data);
		}catch(\Exception $e){
			$result = $this -> model -> ObjReturnCode(202, $e -> getMessage());
		}finally{
			$this -> view -> content(json_encode($result));
		}
	}

	function SaveGoogleCaptcha(){
		$result = null;
		try{
			$form = new Cores\_Form;
			$form 	-> Post('siteKey')
						-> Validate('Regex', Cores\_Setting::_regexGerneral64)
					-> Post('secretKey')
						-> Validate('Regex', Cores\_Setting::_regexGerneral64)
					-> Submit();
			$data = $form -> Fetch();
			$result = $this -> model -> SaveGoogleCaptchaKey($data);
		}catch(\Exception $e){
			$result = $this -> model -> ObjReturnCode(202, $e -> getMessage());
		}finally{
			$this -> view -> content(json_encode($result));
		}
	}
}

?>