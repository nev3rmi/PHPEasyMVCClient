<?php
namespace PHPEasy\Models;
use PHPEasy\Cores as Cores;

class Dashboard extends Cores\_Model{
    function __construct(){
        parent::__construct();
    }

    function Test(){
        echo "In Test";
    }
}
?>