<?php
namespace PHPEasy\Cores;
class _User{
    public $id = null;
    public $firstname = null;
    public $lastname = null;
    public $email = null;
    public $group = null;
    public $avatar = null;
    public $permission = array();
    public $ip = null;

    public function __construct(){
        _Session::Init();
        if (_Session::Get('loggedUser') === null){
            $this -> CreateDumpUser();
        }else{
            $this -> SetIp();
            $this -> SetPermission();
        }
    }

    private function CreateDumpUser(){
        $this -> id = 1;
        $this -> group = array('4');
        $this -> SetIp();
        $this -> SetPermission();
        _Session::Set('loggedUser', $this);
        return $this;
    }

    private function SetIp(){
        $this -> ip = _Site::GetClientIP();
        return $this;
    }

    public function SetPermission(){
        $db = new _Database;
        $allPermission = $db -> Select('SELECT * FROM ('._StoreProcedure::Permission.')Permission WHERE `UserId` = :UserId', array(':UserId' => $this -> id));
        foreach ($allPermission as $permission){
             $functionId = $permission['FunctionId'];
             $permission = $permission['Permission'];
             $this -> permission[$functionId] = $permission;
        }
        $db = null;
        return $this;
    }

    public function __get($name){
        switch ($name){
             case 'fullname':
                return $this->lastname.' '.$this->firstname;
            break;
        }
    }
    
}
?>