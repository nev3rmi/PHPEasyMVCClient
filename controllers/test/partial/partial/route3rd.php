<?php
namespace PHPEasy\Controllers\Test\Route;
use PHPEasy\Cores as Cores;
use PHPEasy\Controllers as Controllers;

class Route3rd extends Controllers\Test\Route{
    function __construct(){
        parent::__construct();
    }

    function Index(){ // Work
        echo $this -> model -> blah1();
        $this -> view -> Content('Route Level 3 work, it is in model level 2');
    }

    function ShowAllClass(){ // Work
        print_r(Cores\_Site::GetClass());
    }

    function TestMultipleModels(){ // Work
        $this -> LoadModel('partial/testPossible', 'models/test/partial/', '\\Test\\Route'); // echo This to get name: test_Test_model
        echo $this -> testPossible_Test_Route_model -> blah4();
        echo '<br>DbConnect: '.$this -> testPossible_Test_Route_model -> TestDBConnection();
    }

    function TestDbConnectionWithModel(){ // Work
        echo $this -> model -> TestDBConnection();
    }

    function TestParam($param){ // Work
        print_r($param);
    }
}
?>