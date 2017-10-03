<?php
namespace PHPEasy\Models;
use PHPEasy\Cores as Cores;

class Auth extends Cores\_Model{

    function CheckPassword($data){
        try{
            $targetPage = new Cores\_Page($data['PostedUrl'], false);
            $hashpassword = $GLOBALS['_Security'] -> HashKey($data['InputPassword']);
    
            if ($GLOBALS['_Security'] -> ValidateHashKeyAndHashEncrypted($hashpassword, $targetPage -> pagePassword)){
                // Create object
                $store = array();
                $store['pageUrl'] = $targetPage -> pageUrl;
                $store['typeInPassword'] = $hashpassword;
    
                Cores\_Session::Set('page-auth', $store);
                
                $obj = $this -> ObjReturnCode(101, implode(',', Cores\_Session::Get('page-auth')));
            }else{
                throw new \Exception ('Password is incorrect!');
            }
            
        }catch (\Exception $e){
            $obj = $this -> ObjReturnCode(201, $e -> getMessage());
        }finally{
            return $obj;
        }
       
	}

}
?>