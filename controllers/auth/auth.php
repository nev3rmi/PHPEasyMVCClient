<?php
namespace PHPEasy\Controllers;
use PHPEasy\Cores as Cores;

class Auth extends Cores\_Controller{
    function __construct(){
		parent::__construct();
    }
    
    function ValidatePage(){
        $this -> view -> cms -> content -> shortcode['*|PostedUrl|*'] = Cores\_Session::Get('page-auth')['pageUrl'];
        $this -> UpdateCMS();
        $this -> view -> render("auth/validatePage");
    }

    function PostToValidate(){
        try{
            $postData = json_decode(file_get_contents("php://input"));
            
            $form = new Cores\_Form;
            $form -> Input("InputPassword",$postData -> InputPassword)
                    -> Validate('Regex', Cores\_Setting::_regexGerneral255)
                  -> Input("PostedUrl",$postData -> PostedUrl)  
                    -> Validate('Regex', Cores\_Setting::_regexUrl)
            ;
            $form -> Submit();
            $data = $form -> Fetch();    

            $result = $this -> model -> CheckPassword($data);
        }catch(\Exception $e){
            $result = $this -> model -> ObjReturnCode(202, $e -> getMessage());
        }finally{
            $this -> view -> content(json_encode($result));
        }
    }
}