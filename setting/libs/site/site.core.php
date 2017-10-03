<?php
namespace PHPEasy\Cores;
class _Site{
	public static function isSSL()
    {
        if( !empty( $_SERVER['https'] ) )
            return 1;

        if( !empty( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' )
            return 1;

        return 0;
    }
	
	public static function GetUrl(){
		global $_useHTTPs;
		return 'http'.(_Setting::_useHTTPs == 1 || self::isSSl() == 1 ? 's' : '').'://' . $_SERVER['SERVER_NAME'].'/';
	}

	public static function GetUrlNoHttp(){
		return $_SERVER['SERVER_NAME'];
	}
	
	public static function GetFullUrl(){
		global $_useHTTPs;
		return 'http'.(_Setting::_useHTTPs == 1 || self::isSSl() == 1 ? 's' : '').'://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	}

	public static function GetFullUrlNoParam(){
		$url = explode("?", self::GetFullUrl());
		return $url[0];
	}
	
	public static function GetDocumentPath(){
		$_getPath = explode('/', $_SERVER['REQUEST_URI']);
		if ($_getPath[1] == '' || !isset($_getPath[1])){
			return '/index';
		}
		return $_SERVER['REQUEST_URI'];
	}
	
	public static function GetRoot(){
		return $_SERVER['DOCUMENT_ROOT'].'/';
	}
	
	public static function GetDocumentBreakDownPath(){
		$_getPath = explode('/', self::GetDocumentPath());
		if ($_getPath[1] == '' || !isset($_getPath[1])){
			$_getPath[1] = 'index';
		}
		return $_getPath;
	}
	
	public static function CountBreakDownPath(){
		return count(self::GetDocumentBreakDownPath());
	}
	
	public static function Copyright(){
		return '&copy; '._Security::GetKey('siteName').' ' . _Security::GetKey('siteCopyrightYear').'. All rights reserved.';
	}

	public static function CompressGzip(){
		if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start('ob_gzhandler'); else ob_start();
	}

	public static function GetClass(){
		return get_declared_classes();
	}

	// Get All const
    public static function GetConst($class){
        return (new \ReflectionClass($class))->getConstants();
    }

	public static function GetDomain($url = ""){
		return parse_url((empty($url)? self::GetUrl() : $url), PHP_URL_HOST);
	}

	public static function GetClientIP(){
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
		return $ip;
	}

	/**
	 * IsPDOAvailable function
	 * Check if PDO exist in this server or not.
	 * @return void
	 */
	public static function IsPDOAvailable(){
		if (!defined('PDO::ATTR_DRIVER_NAME')) {
			_Ultility::ConsoleData('PDO unavailable');
			return false;
		}
		return true;
	}

	function GetIPDetails($ip = null) {
		if (empty($ip)){
			$ip = self::GetClientIP();
		}
		$result = (new _CUrl) -> Send("http://ipinfo.io/$ip", array(), "GET");
		return $result;
	}
}
?>