<?php
namespace PHPEasy\Cores;
class _Setting{ // Site Setting
	// System Config
	// => 0-None, 1-Use
	const _useHTTPs = 0; // Learn how to make a free SSL: http://www.selfsignedcertificate.com/
	const _useGzipCompress = 1;
	const _useDebug = 1; // 0 - Off, 1 - Simple, 2 - All

	// Developer Config
	const _switchSecurity = 1; // 1 - ON, 0 - OFF

	/*
	const _useFileManager = 1;	
	const _useTrigger = 1; // This include config for SMTP, Email, SQL
	const _useMysql = 1; 
	const _usePhpLibrary = 1; 
	
	
	const _useSession = 1;
	*/
	
	
	// Regex Library
	const _regexMail = '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
	const _regexPassword = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/';
	const _regexAlphanumbertic = '/^[A-Za-z0-9]+$/';
	const _regexGerneral = '/^[A-Za-z0-9\ \=\-\_]{1,32}$/';
	const _regexGerneral64 = '/^[A-Za-z0-9\ \=\-\_]{1,64}$/';
	const _regexGerneral255 = '/^[A-Za-z0-9\ \=\-\_\.\,\/]{1,255}$/';
	const _regexUrl = '/^[A-Za-z0-9\ \=\-\/]{1,1024}$/';
	const _regexSearch = '/^[A-Za-z0-9\ \=\-\/\@\.\_]{1,255}$/';
	const _regexPathUrl = '/^(\/\w+)+(\.)?\w+(\?(\w+=[\w\d]+(&\w+=[\w\d]+)*)+){0,1}$/';
	const _regexPathUrlPass = '/^(\-\w+)+(\.)?\w+(\?(\w+=[\w\d]+(&\w+=[\w\d]+)*)+){0,1}$/';
	const _regexIp = '/^\b((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(\.|$)){4}\b$/';
	const _regexFullUrl = '/^https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&\/=]*)$/';
	const _regexDatabase = '/^[A-Za-z0-9_.]+$/';
	const _regexPhoneNumber = '/^(\+{0,1}\d{0,2})(\ {0,1}\-{0,1})(\({0,1}\+{0,1}\d{2,3}\){0,1})(\ {0,1}\-{0,1})(\d{1,4})(\ {0,1}\-{0,1})(\d{1,4})(\ {0,1}\-{0,1})(\d{1,4})$/';
	// const _regexHomeAddress = '/^(?n:(?<address1>(\d{1,5}(\ 1\/[234])?(\x20[A-Z]([a-z])+)+ )|(P\.O\.\ Box\ \d{1,5}))\s{1,2}(?i:(?<address2>(((APT|B LDG|DEPT|FL|HNGR|LOT|PIER|RM|S(LIP|PC|T(E|OP))|TRLR|UNIT)\x20\w{1,5})|(BSMT|FRNT|LBBY|LOWR|OFC|PH|REAR|SIDE|UPPR)\.?)\s{1,2})?)(?<city>[A-Z]([a-z])+(\.?)(\x20[A-Z]([a-z])+){0,2})\, \x20(?<state>A[LKSZRAP]|C[AOT]|D[EC]|F[LM]|G[AU]|HI|I[ADL N]|K[SY]|LA|M[ADEHINOPST]|N[CDEHJMVY]|O[HKR]|P[ARW]|RI|S[CD] |T[NX]|UT|V[AIT]|W[AIVY])\x20(?<zipcode>(?!0{5})\d{5}(-\d {4})?))$/';
	const _regexFacebook = '/(?:https?:\/\/)?(?:www\.)?facebook\.com\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[\w\-]*\/)*([\w\-\.]*)/';
	const _regexAlphabet = '/^[\w]+$/';
	const _regexNumberic = '/^[0-9]+$/';
	
	// Security
	const _securityCharacter = '0123456789abcdefABCDEF';

	// Setup
	const _controllerPath = 'controllers/';
	const _modelPath = 'models/';
	
	const _errorFile = 'error/error';
	const _errorClass = 'Error';
	const _errorMethod = 'Error';

	const _defaultFile = 'index/index'; 
	const _defaultClass = 'Index';
	const _defaultMethod = 'Index';

	const _defaultLogDirectory = 'setting/logs';

	const _defaultTimeZone = 'Asia/Ho_Chi_Minh';
	const _defaultTime = '00:00:00';
	const _defaultDate = 'now';

	const _defaultApiDirectory = 'setting/api';

	// Special GET Case route key which allow to 1024 chars which will use for encrypted object data pass in URL (normal only 32 chars)
	private static $_defaultSpecialRoutedKey = array( // Case sensitive
		'key','encryptedKey'
	); 
	

	// *********************************************************************
	// Init - Will not use this if php over 5.6 -> If over 5.6 will be const
	// *********************************************************************
	public static function _defaultSpecialRoutedKey($key = false){
		return(new _Array(self::$_defaultSpecialRoutedKey)) -> GetArray($key);
	}
}
?>