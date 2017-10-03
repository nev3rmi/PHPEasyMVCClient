<?php
namespace PHPEasy\Cores;
require_once($_SERVER['DOCUMENT_ROOT']."/setting/core.php");

// Autoload Core files
$highPriorFile = array(
    'config.core.php',
    'db.core.php',
    'db.storeprocedure.core.php',
);
$lowPriorFile = array();
(new _Core) -> AutoGetCoreFiles(null, 'core.php', $highPriorFile, $lowPriorFile, true);


// Initial Global Variable
$GLOBALS['_Site'] = new _Site;
$GLOBALS['_Security'] = new _Security;
$GLOBALS['_Ultility'] = new _Ultility;
$GLOBALS['_NOW_'] = new _Clock;
$GLOBALS['_Email'] = new _Email;
$GLOBALS['_Setting'] = new _Setting;
$GLOBALS['_Session'] = new _Session;

// Compress Gzip
if ($GLOBALS['_Setting'] -> _useGzipCompress == 1){
    $GLOBALS['_Site'] -> CompressGzip();
}

if ($GLOBALS['_Setting'] -> _useHTTPs == 1){
    // Should turn on auto redirect to https in cloudflare
    if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
        $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $redirect);
        exit();
    }
}

// Inititate Session
$GLOBALS['_Session'] -> Init();

// Debug mode
if ($GLOBALS['_Setting']::_useDebug == 0){
    error_reporting(0);
}elseif ($GLOBALS['_Setting']::_useDebug == 1){
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    ini_set('display_errors', 'On');
}else{
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
}

?>