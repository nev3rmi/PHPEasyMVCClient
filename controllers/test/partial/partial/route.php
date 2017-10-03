<?php
namespace PHPEasy\Controllers\Test\Route;
use PHPEasy\Cores as Cores;
use PHPEasy\Controllers as Controllers;

class Route extends Controllers\Test\Route{
    function __construct(){
        parent::__construct();
    }

    function Index(){ // work
        echo $this -> model -> blah3();
        $this -> view -> Content('Route Level 3 work');
    }

    function ShowAllClass(){
        print_r(Cores\_Site::GetClass());
    }

    function TestMultipleModels(){ // WORK
        echo $this -> LoadModel('partial/test', 'models/test/partial/', '\\Test\\Route'); // echo This to get name: test_Test_model
        // echo $this -> test_Test_Route_model -> blah4();
        // echo '<br>DbConnect: '.$this -> test_Test_Route_model -> TestDBConnection();
    }

    function TestDbConnectionWithModel(){ // Work
        echo $this -> model -> TestDBConnection();
    }

    function TestParam($param){ // Work
        print_r($param);
    }
    function Route($param){
        $model = array(
			'../ModelName' => 'partial/route', 
			'ModelPath' => 'models/test/partial/partial/', // Always has last slash models/test (/) <- Important
			'ModelNameSpace' => '\\Test\\Route\\Route'
		);
        $this -> LoadPartialController($param, 'controllers/test/partial/partial/partial/route', __METHOD__, $model);
    }
}
?>