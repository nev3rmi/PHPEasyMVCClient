<?php
namespace PHPEasy\Cores;
class _Security{
	private static function RandomKey(){
		$result = '';
		for ($i = 0; $i < 64; $i++){
			$result .= rand(0, strlen(_Setting::_securityCharacter) - 1); 
		}
		return $result;
	}
	
	public static function EncryptKey($decryptkey){
		return strrev(bin2hex(base64_encode($decryptkey)));
	}

	public static function DecryptKey($encryptKey){
		return base64_decode(hex2bin(strrev($encryptKey)));
	}
	
	public static function CreateSalt(){
		try{
			$privateKey = pack('H*', self::RandomKey()); 
			$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
			$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
			$key = $privateKey.'|'.$iv_size.'|'.$iv.'|+';
			$encryptKey = self::EncryptKey($key);
			return $encryptKey;
		}catch (Exception $error){
			_Ultility::ConsoleData('There is No Key Available');
		}
		return;
	}
	
	public static function CreatePassword($password){
		try{
			$hashPassword = self::HashKey($password);
			$encryptedPassword = self::HashEncryptedWithSalt($hashPassword);
			return $encryptedPassword;
		}catch (Exception $error){
			return _Ultility::ConsoleData($error -> errorMessage());
		}
	}
	
	public static function SaveKey($keyFile = '', $keyValue = '', $debug = false){
		try{
			$fileName = $keyFile.'_Key.crypto';
			$filePath = _Site::GetRoot().'setting/key/'.$fileName; 
			/*$fileContent = '<?php $GLOBALS['.$GLOBALS['_q'].'_'.$keyName.'_Key'.$GLOBALS['_q'].'] = "'.$keyValue.'";?>';*/
			$fileContent = $keyValue;
			$file = fopen($filePath,'w');
			fwrite($file,$fileContent);
			fclose($file);
			if ($debug){
				_Ultility::ConsoleData('Save Key Successful!');
			}
		}catch (Exception $error){
			_Ultility::ConsoleData($error -> errorMessage());
		}
		return; 
	}
	
	public static function GetKey($keyFile = ''){
		try{
			$fileName = $keyFile.'_Key.crypto';
			$filePath = _Site::GetRoot().'setting/key/'.$fileName;
			$file = fopen($filePath,'r');
			$fileRead = fread($file,filesize($filePath));
			fclose($file);
			return($fileRead);
		}catch (Exception $error){
			_Ultility::ConsoleData($error -> errorMessage());
		}
		return;
	}
	public static function GetKeyList(){ // Get All Key Available
		$listOfKey = _Folder::GetFilesWithType(_Site::GetRoot().'setting/key/','crypto');
		if (count($listOfKey) > 0){
			return $listOfKey;
		}else{
			_Ultility::ConsoleData('There is No Key Available');
		}
		return;
	}
	
	public static function GetKeyListToString(){
		$result = '';
		$listOfKey = self::GetKeyList();
		if (count($listOfKey) > 0){
			foreach ($listOfKey as $key){
				$explodeKey = explode('_', $key);
				$result .= $explodeKey[0].', ';
			}
		}
		return($result);
	}
	public static function DeleteKey($keyFile = ''){
		try{
			$fileName = $keyFile.'_Key.crypto';
			unlink(_Site::GetRoot().'setting/key/'.$fileName);
			_Ultility::ConsoleData('Delete Key Successful!');
		}catch (Exception $error){
			_Ultility::ConsoleData($error -> errorMessage());
		}
		return;
	}
	
	public static function GetKeyFromKeyList(){
		$result = array();
		$keyList = self::GetKeyList();
		if (count($keyList) > 0){
			foreach ($keyList as $key){
				$explodeKey = explode('_', $key);
				$keyFile = $explodeKey[0];
				try{
					$fileName = $keyFile.'_Key.crypto';
					$filePath = _Site::GetRoot().'setting/key/'.$fileName;
					$file = fopen($filePath,'r');
					$fileRead = fread($file,filesize($filePath));
					fclose($file);
				}catch (Exception $error){
					_Ultility::ConsoleData($error -> errorMessage());
					return;
				}
				array_push($result, $fileRead);
			}
		}
		return $result;
	}
	
	public static function HashKey($inputString){
		// Reverse
		$encryptStep[0] = strrev($inputString);
		// Bin2Hex
		$encryptStep[1] = bin2hex($encryptStep[0]);
		// Base 64 Encode 
		$encryptStep[2] = base64_encode($encryptStep[1]);
		// MD5 Encode  
		$encryptStep[3] = md5($encryptStep[2]); 
		// Hash512
		$encryptStep[4] = hash('sha512', $encryptStep[3]);
		// Finish Here
		return $encryptFinish = $encryptStep[4];
	}
	
	public static function HashEncryptedWithSalt($inputHashKey){
		// Create Salt
		$makeSalt[0] = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_CFB), MCRYPT_DEV_URANDOM);
		$makeSalt[1] = '$6$'.substr(str_shuffle(_Setting::_securityCharacter.$makeSalt[0]), 0, 25); 
		$makeSalt[2] = crypt($inputHashKey,$makeSalt[1]);
		// Encrypt Salt
		$makeSalt[3] = bin2hex(strrev(base64_encode(strrev(base64_encode($makeSalt[2])))));
		// Finish Here
		return $makeSaltFinish = $makeSalt[3];
	}
	
	public static function ValidateHashKeyAndHashEncrypted($inputHashKey, $inputHashEncrypted){
		return (password_verify($inputHashKey,base64_decode(strrev(base64_decode(strrev(hex2bin($inputHashEncrypted)))))))?true:false;
	}
	
	public static function EncryptData($decryptedData, $privateKey = null, $password = null) { 
		if ($privateKey === null){
			$privateKey = _Security::GetKey('privateKey');
		}
		if ($password === null){
			$password = _Security::GetKey('salt');
		}
		// Build a 256-bit $key which is a SHA256 hash of $salt and $password.
		$key = hash('SHA256', $password . $privateKey, true);
		// Build $iv and $iv_base64.  We use a block size of 128 bits (AES compliant) and CBC mode.  (Note: ECB mode is inadequate as IV is not used.)
		srand(); $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC), MCRYPT_RAND);
		if (strlen($iv_base64 = rtrim(base64_encode($iv), '=')) != 22) return false;
		// Encrypt $decrypted and an MD5 of $decrypted using $key.  MD5 is fine to use here because it's just to verify successful decryption.
		$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $decryptedData . md5($decryptedData), MCRYPT_MODE_CBC, $iv));
		// We're done!
		return $iv_base64 . $encrypted;
	} 
	
	public static function DecryptData($encryptedData, $privateKey = null, $password = null) {
		if ($privateKey === null){
			$privateKey = _Security::GetKey('privateKey');
		}
		if ($password === null){
			$password = _Security::GetKey('salt');
		}
		// Build a 256-bit $key which is a SHA256 hash of $salt and $password.
		$key = hash('SHA256', $password . $privateKey, true);
		// Retrieve $iv which is the first 22 characters plus ==, base64_decoded.
		$iv = base64_decode(substr($encryptedData, 0, 22) . '==');
		// Remove $iv from $encrypted.
		$encryptedData = substr($encryptedData, 22);
		// Decrypt the data.  rtrim won't corrupt the data because the last 32 characters are the md5 hash; thus any \0 character has to be padding.
		$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode($encryptedData), MCRYPT_MODE_CBC, $iv), "\0\4");
		// Retrieve $hash which is the last 32 characters of $decrypted.
		$hash = substr($decrypted, -32);
		// Remove the last 32 characters from $decrypted.
		$decrypted = substr($decrypted, 0, -32);
		// Integrity check.  If this fails, either the data is corrupted, or the password/salt was incorrect.
		if (md5($decrypted) != $hash) return false;
		// Yay!
		return $decrypted;
	}

	// Return String
	public static function EncryptObject($objectArray, $privateKey = null, $password = null){
		if ($privateKey === null){
			$privateKey = _Security::GetKey('privateKey');
		}
		if ($password === null){
			$password = _Security::GetKey('salt');
		}

		return self::EncryptKey(self::EncryptData(serialize($objectArray),$privateKey,$password));
	}

	// Return Array/Object
	public static function DecryptObject($hashObject, $privateKey = null, $password = null){
		if ($privateKey === null){
			$privateKey = _Security::GetKey('privateKey');
		}
		if ($password === null){
			$password = _Security::GetKey('salt');
		}
		$key = $hashObject;
        $key = self::DecryptKey($key);
        $key = self::DecryptData($key, $privateKey, $password);
        $key = unserialize($key);
		return $key;
	}
}
?>