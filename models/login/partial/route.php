<?php
namespace PHPEasy\Models\Login;
use PHPEasy\Cores as Cores;
use PHPEasy\Models as Models;

class Route extends Models\Login{
    function __construct(){
		parent::__construct();
	}
	protected function CreateUserObject($email){
		$getUser = $this -> db -> Select (
			"SELECT a.UserId, FirstName, LastName, AvatarUrl, GroupId, Email  FROM `User` a 
				JOIN UserInGroup b ON a.UserId = b.UserId
				WHERE a.`Email` = :email",
				array(':email' => $email)
		);
		if (count($getUser) > 0){
			Cores\_Session::Init();
			$loggedUser = new Cores\_User;
			$loggedUser -> id = $getUser[0]['UserId'];
			$loggedUser -> firstname = $getUser[0]['FirstName'];
			$loggedUser -> lastname = $getUser[0]['LastName'];
			$loggedUser -> avatar = $getUser[0]['AvatarUrl'];
			$loggedUser -> email = $getUser[0]['Email'];
			$group = array();
			foreach ($getUser as $user){
				$group[] = $user['GroupId']; 
			}
			$loggedUser -> group = $group;
			$loggedUser -> SetPermission();
			Cores\_Session::Set('loggedUser', $loggedUser);
			return true;
		}
		throw new \Exception("This user is not exist", 1);
		return false;
	}

	protected function CreateOwner($userId){
		$queryString = "SELECT `UserId` FROM `User`";
		$getUser = $this -> db -> Select($queryString);
		if (count($getUser) == 2){
			$this -> db -> Insert('UserInGroup', array(
				'UserId' => $userId,
				'GroupId' => 1,
				'Description' => 'Owner User'
			));
		}
	}

	protected function CreatePersonalGroup($userId){
		// Create Personal Group
		$this -> db -> Insert('Group', array(
			'GroupName' => 'PersonalGroup_'.$userId,
			'GroupDescription' => 'Personal group of user '.$userId
		));

		$personalGroupId = $this -> db -> lastInsertId();

		$this -> db -> Insert('UserInGroup', array(
			'UserId' => $userId,
			'GroupId' => $personalGroupId,
			'Description' => 'Personal group of user '.$userId
		));
	}
}