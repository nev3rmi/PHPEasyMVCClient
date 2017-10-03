<?php
namespace PHPEasy\Cores;

(new _Plugin('PHPMailer/PHPMailerAutoload'));

class _Email extends \PHPMailer{
    function __construct($emailObj = array()){
		parent::__construct();
        $this -> Init($emailObj);   
	}

    private function Init($emailObj = array()){
        if (empty($emailObj)){
            $emailObj = json_decode(_Security::DecryptData(_Security::GetKey('smtpConnectString'), _Security::GetKey('privateKey'), _Security::GetKey('salt')), true);
        }
        try{
            $this -> isSMTP();
            $this -> Host = $emailObj["host"];  // Specify main and backup SMTP servers
            $this -> SMTPAuth = $emailObj["auth"];                               // Enable SMTP authentication
            $this -> Username = $emailObj["username"];                 // SMTP username
            $this -> Password = $emailObj["password"];                           // SMTP password
            $this -> SMTPSecure = $emailObj["secure"];                            // Enable TLS encryption, `ssl` also accepted
            $this -> Port = $emailObj["port"];
            $this -> Storage -> Address -> Bot = $emailObj['address']["bot"];
            $this -> Storage -> Address -> Admin = $emailObj['address']["admin"];    
        }catch (\Exception $e){
            (new Cores\_Error) -> ShowError($e -> getMessage());
        }      
    }

    function SetTemplate($pageUrl, $shortCode){
        //TODO: Add permission in future
        $page = new _Page($pageUrl);
        return str_replace(array_keys($shortCode), array_values($shortCode), html_entity_decode ($page -> pageContent));
    }

}