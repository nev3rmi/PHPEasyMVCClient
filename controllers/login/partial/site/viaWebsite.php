<?php
namespace PHPEasy\Controllers\Login\Route;
use PHPEasy\Cores as Cores;
use PHPEasy\Controllers as Controllers;

class ViaWebsite extends Controllers\Login\Route{
    function __construct(){
        parent::__construct();
    }
    
    function Run(){
        try
        {
            // Captcha Check
            if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
                $secret = Cores\_Security::DecryptObject(Cores\_Security::GetKey('GoogleCaptcha'))['privateKey'];

                $gRecaptcha = $_POST['g-recaptcha-response'];
                $gRecaptcha = "https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$_POST['g-recaptcha-response'];

                $response = file_get_contents($gRecaptcha);
                $responseData = json_decode($response);
                if(!$responseData->success){
                    throw new \Exception("Captcha => Invalid", 1);
                }
            }else{
                if (isset($_POST['g-recaptcha-response'])){
                    throw new \Exception("Captcha => Please fill in", 1);
                }
            }
            // Put to form
            $form = new Cores\_Form;
            if ($_POST['repassword']){
                $form  -> Post('email')
                    -> Validate('Regex', Cores\_Setting::_regexMail)
                    -> Post('password')
                    -> Validate('Regex', Cores\_Setting::_regexPassword)
                    -> Post('repassword')
                    -> Validate('Regex', Cores\_Setting::_regexPassword)
                    -> Validate('ExactlyMatch', $_POST['password'])
                    ;
            }else{
                $form  -> Post('email')
                    -> Validate('Regex', Cores\_Setting::_regexMail)
                    -> Post('password')
                    -> Validate('Regex', Cores\_Setting::_regexPassword);
            }
            $form -> Submit();
            $data = $form -> Fetch();

            $result = $this -> model -> Run($data);
            $this -> view -> Content($result);
        }catch (\Exception $e){
            $this -> view ->  Content ($e -> getMessage()); 
        }
	}
}

?>