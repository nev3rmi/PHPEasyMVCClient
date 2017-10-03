<?php
namespace PHPEasy\Models\Admin;
use PHPEasy\Cores as Cores;
use PHPEasy\Models as Models;

class Controller extends Models\Admin{
    function GetDataForControllerTable(){
        // Init
        $ajax = array();
        $data = array();
        $queryString = "SELECT * FROM `Controller`";
        $arraySearch = array();
        $getData = $this -> db -> Select($queryString, $arraySearch);
        foreach ($getData as $returnData){
            foreach($returnData as $key => $value){
                $row[$key] = $value;
            }
            /* Edit HERE */
            $editActionColummn = '<a href="javascript:;" class="btn btn-sm btn-success" onclick="GetFormToAddUpdateController('.$returnData['ControllerId'].')" data-toggle="tooltip" title="Edit Controller Id: '.$returnData['ControllerId'].'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
            $deleteActionColumn = '<a href="javascript:;" class="btn btn-sm btn-danger" onclick="GetFormToDeleteController('.$returnData['ControllerId'].')" data-toggle="tooltip" title="Delete Controller Id: '.$returnData['ControllerId'].'"><i class="fa fa-trash" aria-hidden="true"></i></a>';

            $row["Action"] =  $editActionColummn.$deleteActionColumn;
            $row["ControllerRowId"] = "row_".$returnData['ControllerId'];
            /* End Edit */

            $data[] = $row;
        }
        // Prepare Ajax
        $ajax["draw"] = 1;
        $ajax["recordsTotal"] = count($getData);
        $ajax["recordsFiltered"] = count($getData);
        $ajax["data"] = $data;

        return $ajax;
        
    }
	
    function Run($data){
        $this -> _data = $data;
        if (empty($this -> _data['controllerId'])){
            return $this -> AddNewController();
        }else{
            return $this -> UpdateController();
        }
    }

    private function AddNewController(){
        try{
            return $this -> db -> Insert('Controller', $this -> _data, "SELECT `ControllerName` FROM `Controller` WHERE `ControllerName` = :controllerName", 
                array(
                    ":controllerName" => $this -> _data['controllerName']
                )
            );
        }catch (\Exception $e){
            return $e -> getMessage();
        }
        
    }
    private function UpdateController(){
        try{
            return $this -> db -> Update('Controller', array('ControllerName' => $this -> _data['controllerName']), '`ControllerId` = :ControllerId', array(':ControllerId' => $this -> _data['controllerId']));
        }catch (\Exception $e){
            return $e -> getMessage();
        }
    }

    function GetData($controllerId){
        $queryString = 'SELECT `ControllerName` FROM `Controller` WHERE `ControllerId` = :ControllerId';

        $data = $this -> db -> Select($queryString, array(
            ':ControllerId' => $controllerId
        ), false);
        return $data;
    }

    function DeleteController($controllerId){
        try{
            // Make sure there is no Function Exist before delete `Controller`
            $selectController = $this -> db -> Select('SELECT `FunctionId` FROM `Function` WHERE `ControllerId` = :ControllerId', array(
                ':ControllerId' => $controllerId
            ));
            if (count($selectController) > 0){
                return 'Cannot delete this controller because, '.count($selectController).' page'.(count($selectController) > 1?'s':'').' exist in this controllers.<br> Please delete all pages before delete the controller.';
            }

            $data = $this -> db -> Delete('DELETE FROM `Controller` WHERE `ControllerId` = :ControllerId', array(':ControllerId' => $controllerId));

            return $data;
        }catch (\Exception $e){
            return $e -> getMessage();
        }
    }
    
}
?>