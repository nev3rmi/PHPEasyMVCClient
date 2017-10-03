<?php
namespace PHPEasy\Controllers\Admin;
use PHPEasy\Cores as Cores;
use PHPEasy\Controllers as Controllers;

class Group extends Controllers\Admin{
    function __construct(){
		parent::__construct();
	}

    function Index($param){
        $this -> GetGroup();
    }

    function GetGroup(){
         // Render
        $this -> view -> title = 'Groups | User | Admin Dashboard';
		$this -> view -> render ('admin/group','admin/_layout/_head','admin/_layout/_body');
    }

    function GetDataForGroupTable(){
        $data = $this -> model -> GetGroup();
        $this -> view -> content(json_encode($data));
    }

    // [PartialView] -> Form to Add New Page, Edit Page
    function GetFormForAddUpdateGroup($param){
        try{
            $groupId = preg_replace('/\s+/', '', $param['GroupId']);
            if (!empty($groupId)){
                $form = new Cores\_Form;
                $form -> Input('GroupId', $groupId) -> Validate('Digit') -> Submit();
                $data = $form -> Fetch();
                if ($groupId !== 0){
                    $getData = $this -> model -> GetData($data['GroupId']);
                    if ($getData !== null){
                        $this -> view -> data = $getData;
                    }
                }
            }
            $this -> view -> render ('admin/partial/group/add-update-form', null, null, true);
        }catch (\Exception $e){
            (new Cores\_Error) -> ShowError($e -> getMessage());
        }
    }

    function GetDataFromFormAddInsertGroup(){
        try{
            $form = new Cores\_Form;
            $form -> Post('groupId')
                  -> Validate('Digit')
                  -> Post('groupName')
                  -> Validate('Regex', Cores\_Setting::_regexGerneral)
                  -> Input('groupDescription', $_POST['description'])
                  -> Validate('Regex', Cores\_Setting::_regexGerneral255) 
                  ;
            $form -> Submit();
            $data = $form -> Fetch();
            echo $this -> model -> Run($data);
        }catch (\Exception $e){
            // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Failed to update/add permission for group: '.$data['groupId'], "\nError:\n".$e -> getMessage());
            (new Cores\_Error) -> ShowError($e -> getMessage());
        }
    }

    function DeleteGroup(){
        try{
            $form = new Cores\_Form;
            $form -> Post('groupId')
                  -> Validate('Digit');
            $form -> Submit();
            $data = $form -> Fetch();
            // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Delete Group', implode(", ",$data));
            echo $this -> model -> DeleteGroup($data['groupId']);
        }catch (\Exception $e){
            // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Delete Group FAIL', "\nError:\n".$e -> getMessage());
            (new Cores\_Error) -> ShowError($e -> getMessage());
        }   
    }

    function GETUserInGroup($param){
        try{
            $form = new Cores\_Form;
            $form -> Input('groupId', $param['GroupId'])
                  -> Validate('Digit');
            $form -> Submit();
            $data = $form -> Fetch();

            Cores\_Session::Set("CurrentUserInGroup", $param['GroupId']);

            $this -> view -> js = array(
                Cores\_Site::GetUrl().'views/admin/partial/group/js/user-in-group.js'
            );
            $this -> view -> render ('admin/partial/group/view-user-in-group', null, null, true);
        }catch (\Exception $e){

        }
        

    }

    function GETJSONUserInGroup(){
        try{
            $data = Cores\_Session::Get("CurrentUserInGroup");
            $returnData = $this -> model -> GetUserInGroup($data);
            $this -> view -> content(json_encode($returnData));
        }catch (\Exception $e){

        }
    }

    function GETFormForAddNewUserToGroup(){
        $this -> view -> js = array(
                Cores\_Site::GetUrl().'views/admin/partial/group/js/select2-user-in-group.js'
            );
        $this -> view -> Render('admin/partial/group/add-new-user-to-group-form', null, null, true);
    }

    function GETJSONAllUserNotInGroup(){
        try{
            $form = new Cores\_Form;
            $form -> Post('requestParam')
                  -> Validate('Regex', Cores\_Setting::_regexGerneral);
            $form -> Submit();
            $data = $form -> Fetch();

            $returnData = $this -> model -> GetUserNOTInGroup($data);
            $this -> view -> content(json_encode($returnData));
        }catch (\Exception $e){

        }
    }

    function POSTAddNewUserToGroup(){
        try{
            $form = new Cores\_Form;
            $form -> Post('userId')
                  -> Validate('Digit');
            $form -> Submit();
            $data = $form -> Fetch();

            $returnData = $this -> model -> AddNewUserToGroup($data);
            echo true;
        }catch (\Exception $e){
            echo $e -> GetMessage();
        }
    }

    function POSTDeleteUserFromGroup(){
        try{
            $form = new Cores\_Form;
            $form -> Post('userId')
                  -> Validate('Digit');
            $form -> Submit();
            $data = $form -> Fetch();

            echo $returnData = $this -> model -> RemoveUserFromGroup($data);
        }catch (\Exception $e){
            echo $e -> GetMessage();
        }
    }
}