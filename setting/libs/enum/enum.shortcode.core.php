<?php
namespace PHPEasy\Cores;


$GLOBALS['_ShortCode'] = 
    array(
        '*|PageName|*' => _Security::GetKey('siteName'),
        '*|Copyright|*' => _Site::Copyright(),
        '*|DateTime|*' => date("d-m-Y H:i:s", strtotime((new _Clock) -> clockDateTime)) // Clock doesn't finish loaded
    )
; 

?>