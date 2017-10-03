<?php
namespace PHPEasy\Controllers\Test\Route\Route;
use PHPEasy\Cores as Cores;
use PHPEasy\Controllers as Controllers;

class Route extends Controllers\Test\Route\Route{
    function __construct(){
        parent::__construct();
    }

    function Index(){ // work
        // echo $this -> model -> blah3();
        $this -> view -> Content('Route Level 4 work');
    }

}

?>