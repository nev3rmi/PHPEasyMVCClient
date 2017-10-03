<?php
namespace PHPEasy\Controllers\Test;
use PHPEasy\Cores as Cores;
use PHPEasy\Controllers as Controllers;

class Route extends Controllers\Test{

    public $model = null;

    function __construct(){
        parent::__construct();
    }

    function Index(){ // Work // -> Just check: All Index need to have $param
        $this -> model -> blah();
        $this -> view -> Content('Work');
    }

    function ShowAllClass(){ // All the function must be below 64 chars
        print_r(Cores\_Site::GetClass());
    }

    function TestMultipleModels(){ // WORK
        $this -> LoadModel('partial/test', 'models/test/', '\\Test'); // echo This to get name: test_Test_model
        echo $this -> test_Test_model -> blah2();
        echo '<br>DbConnect: '.$this -> test_Test_model -> TestDBConnection();
    }

    function TestDbConnectionWithModel(){ // Work
        echo $this -> model -> TestDBConnection();
    }

    function TestParam($param){ // Work
        print_r($param);
    }

    function Route($param){ // Model Not Work, Need to fix max_user_connection first before route more
        $model = array(
			'../ModelName' => 'partial/route', 
			'ModelPath' => 'models/test/partial/', // Always has last slash models/test (/) <- Important
			'ModelNameSpace' => '\\Test\\Route'
		);
        $this -> LoadPartialController($param, 'controllers/test/partial/partial/route', __METHOD__, $model);
    }

    function Route3rd($param){
        $model = array(
			'../ModelName' => 'partial/route', 
			'ModelPath' => 'models/test/', // Always has last slash models/test (/) <- Important
			'ModelNameSpace' => '\\Test'
		);
        $this -> LoadPartialController($param, 'controllers/test/partial/partial/route3rd', __METHOD__, $model);
    }
}
?>
