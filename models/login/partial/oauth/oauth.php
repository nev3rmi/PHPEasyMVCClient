<?php
namespace PHPEasy\Models\Login\Route;
use PHPEasy\Cores as Cores;
use PHPEasy\Models as Models;

class Oauth extends Models\Login\Route{
    function __construct(){
		parent::__construct();
	}

	protected function RunUserLogin($data){
		// TODO: Dynamic this to use with Google
		if (!empty($data['FacebookOauthId'])){
			$oauthId = 'FacebookOauthId';
		}
		if (!empty($data['GoogleOauthId'])){
			$oauthId = 'GoogleOauthId';
		}

		$queryString = "SELECT `Email`,`".$oauthId."` FROM `User` WHERE `Email` = :email";

		$queryUser = $this -> db -> Select(
			$queryString,
			array(
				':email' => $data['Email']
				),
			false
		);

		if (count($queryUser) > 0){
			// Check exist FbId
			if (!empty($queryUser[$oauthId])){
				// Login
				return $this -> Login($data);
			}else{
				// Update Fb ID
				$this -> UpdateOauthUser($data);
			}
		}else{
			// Not exist Email
			$this -> InsertNewUser($data);
		}
		$this -> RunUserLogin($data);

	}

	private function InsertNewUser($data){
		try{
			$prepareInsert = array();
			foreach ($data as $key => $value){
				$prepareInsert[$key] = $data[$key];
			}

			$this -> db -> Insert('User', $prepareInsert);

			//Insert Current User to Group
			$queryString = "SELECT `UserId` FROM `User` WHERE `Email` = :email";
			$getUser = $this -> db -> Select($queryString, array(':email' => $data['Email']), false);
			
			$this -> db -> Insert('UserInGroup', array(
				'UserId' => $getUser['UserId'],
				'GroupId' => 4,
				'Description' => 'Oauth User'
			));
			$this -> db -> Insert('UserInGroup', array(
				'UserId' => $getUser['UserId'],
				'GroupId' => 5,
				'Description' => 'Oauth User'
			));

			// Create Personal Group
			$this -> CreatePersonalGroup($getUser['UserId']);
			
			// Create owner user.
			$this -> CreateOwner($getUser['UserId']);

		}catch (\Exception $e){
			return $e -> getMessage();
		}
	}

	private function UpdateOauthUser($data){
		try{
			$implodeData = "`".implode("`, `", array_keys($data))."`";
			$queryString = "SELECT ".$implodeData." FROM `User` WHERE `Email` = :email";
			
			$getUserInfo = $this -> db -> Select($queryString, 
			array(
				':email' => $data['Email'] 
			), false);

			$updateArray = array();

			foreach ($getUserInfo as $key => $value){
				if (empty($value)){ // Need to think when to update
					$updateArray[$key] = $data[$key];
				}
			}

			$this -> db -> Update('User', $updateArray, '`Email` = :email', array(':email' => $data['Email']));
		}catch (\Exception $e){
			return $e -> getMessage();
		}
	}

	private function Login($data){
		$email = $data['Email'];
		$this -> CreateUserObject($email);
	}
}