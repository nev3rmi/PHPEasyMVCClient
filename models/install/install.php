<?php
namespace PHPEasy\Models;
use PHPEasy\Cores as Cores;

class Install extends Cores\_Model{
	function __construct(){
		parent::__construct();
	}
	function SaveKey($data){
        try{
            $salt = $data['key'];
            $GLOBALS['_Security']->SaveKey('salt',$salt);
            $hashPrivateKey = $GLOBALS['_Security']->HashEncryptedWithSalt($salt);
            $GLOBALS['_Security']->SaveKey('privateKey', $hashPrivateKey);           
            $obj = $this -> ObjReturnCode(101, 'Save Key Successful!');
        }catch (\Exception $e){
            $obj = $this -> ObjReturnCode(201, "Save Key Failed: ". $e-> GetMessage());
        }finally{
            return $obj;
        }
	}

    function SaveDatabase($data){
        try{
            $key = $this -> GetSaltandPrivateKey();
            $dbConnectToString = $data['hostname'].'|'.$data['username'].'|'.$data['password'].'|'.$data['dbname'].'|++';
            $encryptDbConnectString = $GLOBALS['_Security']->EncryptData ($dbConnectToString, $key['PrivateKey'], $key['Salt']);
            $GLOBALS['_Security']->SaveKey('dbConnectString', $encryptDbConnectString);
            $_Database = new Cores\_Database;
            if ($_Database -> IsDbConnected()){
                $db_path = './installer/Install.sql';
                // Run script to install database
                $sql = file_get_contents($db_path);
                $qr = $_Database->exec($sql);
                if ($qr === 0){
                    $obj = $this -> ObjReturnCode(101, 'Install Database Successful!');
                }elseif($qr === 1){
                    $obj = $this -> ObjReturnCode(101, 'Database is already exist, Skip this step!');
                }else{
                    throw new \Exception(implode("\n", $_Database -> errorInfo()));
                }
            }else{
                throw new \Exception('Cannot connect to Database');
            }
            $_Database = null;
        }catch (\Exception $e){
            $obj = $this -> ObjReturnCode(201, "Install Database Failed: ". $e-> GetMessage());
        }finally{
            return $obj;
        }
    }

    function SaveCurrentStep($data){
        return $GLOBALS['_Security']->SaveKey('installCurrentStep',$data['currentStep']);
    }

    function GetCurrentStep(){
        $return = array();
        $return['step'] = (int)$GLOBALS['_Security']->GetKey('installCurrentStep');
        return $return;
    }

    function GetSaltandPrivateKey(){
        $obj = array();
        $obj['PrivateKey'] = $GLOBALS['_Security']->GetKey('privateKey');
        $obj['Salt'] = $GLOBALS['_Security']->GetKey('salt');
        return $obj;
    }

    function CheckKeyLicense($data){
        $curl = new Cores\_CUrl;

        $result = $curl -> Send('http://codeasy.cf/api/License/RequestActiveLicense', array(
            'key' => $data['key'],
            'ip' => $data['ip'],
            'url' => $data['url']
        ));

       $result = \json_decode($result);

       return $result;
    }

    function SaveGoogleKey($data){
        try{
            $GLOBALS['_Security']->SaveKey ('siteName', $data['siteName']);
            $GLOBALS['_Security']->SaveKey ('sitePublisher', $data['sitePublisher']);
            $GLOBALS['_Security']->SaveKey ('siteCopyrightYear', $data['copyrightYear']);
            $GLOBALS['_Security']->SaveKey ('siteFanpage', $data['fanpage']);
            $GLOBALS['_Security']->SaveKey ('siteContact', $data['siteContact']);
            $GLOBALS['_Security']->SaveKey ('siteAddress', $data['siteAddress']);
            $GLOBALS['_Security']->SaveKey ('siteEmail', $data['siteEmail']);
            $GLOBALS['_Security']->SaveKey ('siteDescription', $data['description']);
            $GLOBALS['_Security']->SaveKey('googleSiteVerficationKey',$data['googleKey']);

            $obj = $this -> ObjReturnCode(101, 'Save Site Meta Successful!');
        }catch (\Exception $e){
            $obj = $this -> ObjReturnCode(201, $e -> GetMessage());
        }finally{
            return $obj;
        }
        
        
    }

    function SaveGoogleCaptchaKey($data){
        $goocapobj = array('siteKey' => $data['siteKey'], 'privateKey' => $data['secretKey']);
        $goocapobjenc = $GLOBALS['_Security']->EncryptObject($goocapobj);
        $GLOBALS['_Security']->SaveKey ('GoogleCaptcha', $goocapobjenc);
        return  $obj = $this -> ObjReturnCode(101, 'Save GoogleCaptchaKey Successful!');
    }

    function createSystemFile($siteInfo){
        $getPrivateKey = Cores\_Security::GetKey('privateKey');
        $getSalt = Cores\_Security::GetKey('salt');
        Cores\_Security::EncryptData ($siteInfo, $getPrivateKey, $getSalt);
        Cores\_Security::SaveKey('system',$siteInfo);
    }
}
?>