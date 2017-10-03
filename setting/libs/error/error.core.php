<?php
namespace PHPEasy\Cores;
class _Error {
    function ShowError($errorMessage){
        echo 'Request Failed: ' . $errorMessage . '!';
        exit;
    }
}
?>