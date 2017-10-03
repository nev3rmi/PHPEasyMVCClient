<?php
namespace PHPEasy\Controllers\Admin;
use PHPEasy\Cores as Cores;
use PHPEasy\Controllers as Controllers;

class Controller extends Controllers\Admin{
    function __construct(){
		parent::__construct();
	}

    function Index(){
        header('Location: /admin/page');
    }

    
    function FORMInsertNewController($param){ // 32 Chars
        try{
            $controllerId = preg_replace('/\s+/', '', $param['ControllerId']);
            if (!empty($controllerId)){
                $form = new Cores\_Form;
                $form -> Input('controllerId', $controllerId) -> Validate('Digit') -> Submit();
                $data = $form -> Fetch();
                if ($controllerId !== 0){
                    $getData = $this -> model -> GetData($data['controllerId']);
                    if ($getData !== null){
                        $this -> view -> data = $getData;
                    }
                }
            }
            $this -> view -> render ('admin/partial/controller/add-update-form', null, null, true);
        }catch (\Exception $e){
            (new Cores\_Error) -> ShowError($e -> getMessage());
        }
    }

    // [HTTP POST]
    function POSTInsertUpdateController(){
        // Form implements
        try{
            $form = new Cores\_Form;
            $form -> Input('controllerName', ($_POST['controllerName'] == null ? $_POST['value'] : $_POST['controllerName']))
                  -> Validate('Regex', Cores\_Setting::_regexGerneral)
                  -> Input('controllerId', ($_POST['controllerId'] == null ? $_POST['pk'] : $_POST['controllerId']))
                  -> Validate('Digit')
            ;
            $form -> Submit();
            $data = $form -> Fetch();
            // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Do action Insert/Update Controller', implode(", ",$data));
            echo $this -> model -> Run($data);
            // Log Success
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('==> SUCCESS', implode(", ",$data));
        }catch (\Exception $e){
            // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('==> FAIL', "\nError:\n".$e -> getMessage());
            (new Cores\_Error) -> ShowError($e -> getMessage());
        }
    }

    function POSTDeleteController(){
        try{
            $form = new Cores\_Form;
            $form -> Post('controllerId')
                  -> Validate('Digit');
            $form -> Submit();
            $data = $form -> Fetch();
            // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Delete Controller', implode(", ",$data));
            echo $this -> model -> DeleteController($data['controllerId']);
        }catch (\Exception $e){
            // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Delete Controller FAIL', "\nError:\n".$e -> getMessage());
            (new Cores\_Error) -> ShowError($e -> getMessage());
        }   
    }
}
?>