<?php
namespace PHPEasy\Cores;
class _Model{
	function __construct(){
		$this -> db = new _Database();
		$this -> loggedUser = _Session::Get('loggedUser');
	}

	function ObjReturnCode($codeNumber, $message){
        $obj = array();
        $obj['result'] = $codeNumber;
        $obj['message'] = $message;
        return $obj;
    }

}
?>