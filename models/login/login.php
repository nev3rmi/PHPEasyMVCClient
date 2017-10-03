<?php
namespace PHPEasy\Models;
use PHPEasy\Cores as Cores;

class Login extends Cores\_Model{

	function __construct(){
		parent::__construct();
	}

	

		// $getUser = $this -> db -> prepare("SELECT UserId, Password, FirstName, LastName, AvatarUrl FROM `User` WHERE `Email` = :email");
		// $getUser -> execute(array(
		// 	':email' => $email
		// ));
		// $countUser = $getUser -> rowCount();
		// if ($countUser > 0){
		// 	// Fetch data
		// 	$queryUser = $getUser -> fetch($this -> db -> FETCH_ASSOC); 
		// 	// Check If Password is correct
		// 	$hashPassword = $GLOBALS['_Security'] -> HashKey($password);
		// 	if ($GLOBALS['_Security'] -> ValidateHashKeyAndHashEncrypted($hashPassword, $queryUser['Password'])){
		// 		$GLOBALS['_Ultility'] -> ConsoleData ('Password Correct'); 
		// 		_Session::Init();
		// 		$loggedUser = new _User;
		// 		$loggedUser -> id = $queryUser['UserId'];
		// 		$loggedUser -> firstname = $queryUser['FirstName'];
		// 		$loggedUser -> lastname = $queryUser['LastName'];
		// 		$loggedUser -> avatar = $queryUser['AvatarUrl'];
		// 		$loggedUser -> SetPermission();
		// 		_Session::Set('loggedUser', $loggedUser);
		// 		header("location: ".$GLOBALS['_Site'] -> GetUrl()."dashboard");
		// 	}else{
		// 		header("location: ".$GLOBALS['_Site'] -> GetUrl()."login");
		// 		$GLOBALS['_Ultility'] -> ConsoleData ('Password Incorrect');
		// 	}
		// }else{
		// 	header("location: ".$GLOBALS['_Site'] -> GetUrl()."login");
		// 	$GLOBALS['_Ultility'] -> ConsoleData ('User is not exist');
		// }
}
?>