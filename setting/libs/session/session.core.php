<?php
namespace PHPEasy\Cores;
class _Session
{
    public static function Init(){
        if (session_status() == PHP_SESSION_NONE || session_id() == '') {
            session_start();
        }
    }

    public static function Set($key, $value){
        $_SESSION[$key] = $value;
    }

    public static function Get($key){
        return $_SESSION[$key];
    }

    public static function Destroy($sessionName = null){
        switch (func_num_args()){
			case 0: session_destroy(); break;
            case 1: unset($_SESSION[$sessionName]);
        }
        
    }
}
?>