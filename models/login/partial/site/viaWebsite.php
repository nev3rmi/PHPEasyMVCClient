<?php
namespace PHPEasy\Models\Login\Route;
use PHPEasy\Cores as Cores;
use PHPEasy\Models as Models;

class ViaWebsite extends Models\Login\Route{
    function __construct(){
		parent::__construct();
	}

    function Run($data){ // TODO: Need refactor
		$email = $data['email'];
		$password = $data['password'];
		$repassword = isset($data['repassword']) ? $data['repassword'] : null;
		$hashPassword = $GLOBALS['_Security'] -> HashKey($password);

		$queryUser = $this -> db -> Select(
			"SELECT UserId, Password FROM `User` WHERE `Email` = :email",
			array(':email' => $email),
			false
		);

		if (!empty($queryUser)){ // -> Auto sign in
			if ($GLOBALS['_Security'] -> ValidateHashKeyAndHashEncrypted($hashPassword, $queryUser['Password'])){
				$this -> CreateUserObject($email);
			}else{
				if (isset($repassword) && !empty($repassword)){
					throw new \Exception("This Email is already exist", 1);
				}else{
					throw new \Exception("Username / Password is incorrect", 1);
				}
			}
		}else{
			if (isset($repassword)){ // If register // TODO: Finish it with email send to active
				// Do Insert new user -> // Call back function Re-login
				$insertNewUser = array(
					'Email' => $email,
					'Password' => Cores\_Security::HashEncryptedWithSalt($hashPassword),
					'PrivateKey' => Cores\_Security::CreateSalt(),
					'FirstName' => "User",
					'LastName' => "New",
					'IsActive' => 1, // -> If implement email send active will set to 0
					'ActiveToken' => "" // Encrypt user info
				);
				$this -> db -> Insert('User', $insertNewUser);
				$queryString = "SELECT `UserId` FROM `User` WHERE `Email` = :email";
				$getUser = $this -> db -> Select($queryString, array(':email' => $email), false);
				
				$this -> db -> Insert('UserInGroup', array(
					'UserId' => $getUser['UserId'],
					'GroupId' => 4,
					'Description' => 'Registered User'
				));
				$this -> db -> Insert('UserInGroup', array(
					'UserId' => $getUser['UserId'],
					'GroupId' => 5,
					'Description' => 'Registered User'
				));

				// Create Personal Group
				$this -> CreatePersonalGroup($getUser['UserId']);

				// Create owner user.
				$this -> CreateOwner($getUser['UserId']);

				$this -> Run($data);
				// throw new \Exception(Cores\_Security::CreateSalt(),1);
			}else{ // In login
				throw new \Exception("User is not exist, please sign up", 1);
			}
		}
    }	
}