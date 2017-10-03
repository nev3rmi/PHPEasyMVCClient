<?php
namespace PHPEasy\Controllers\Admin;
use PHPEasy\Cores as Cores;
use PHPEasy\Controllers as Controllers;

class Page extends Controllers\Admin{
    function __construct(){
		parent::__construct();
	}

    function Index($param){
        $this -> MainPage($param);
    }

    private function MainPage($param){
        // Render
        $this -> view -> title = 'Pages | Sitemap | Admin Dashboard';
		$this -> view -> render ('admin/page','admin/_layout/_head','admin/_layout/_body');
    }

    // [PartialView] - Get Data for page table
    function GETJSONPageTables(){
        // TODO: Check different if not stay back
        $data = $this -> model -> GetDataForPageTable(); // Return Object -> Convert it to json data
        $this -> view -> Content(json_encode($data));
    }

    // [PartialView] -> Form to Add New Page, Edit Page
    function FORMAddUpdatePage($param){
        try{
            $functionId = preg_replace('/\s+/', '', $param['FunctionId']);
            if (!empty($functionId)){
                $form = new Cores\_Form;
                $form -> Input('functionId', $functionId) 
                      -> Validate('Digit') 
                      -> Submit();
                $data = $form -> Fetch();
                if ($controllerId !== 0){
                    $getData = $this -> model -> GetData($data['functionId']);
                    if ($getData !== null){
                        $this -> view -> data = $getData;
                    }
                }
            }
            $this -> view -> js = array(
                Cores\_Site::GetUrl().'views/admin/partial/page/js/add-update-form-custom.js'
            );
            $this -> view -> render ('admin/partial/page/add-update-form', null, null, true);
        }catch (\Exception $e){
            // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Show form FORMAddUpdatePage Failed', "\nError:\n".$e -> getMessage());
            (new Cores\_Error) -> ShowError($e -> getMessage());
        }
    }

    // [HTTP POST]
    function POSTInsertUpdatePage(){
        try{
            $form = new Cores\_Form;
            $form -> Post('functionId')
                    -> Validate('Digit')
                  -> Post('functionName')
                    -> Validate('Regex', Cores\_Setting::_regexGerneral)
                  -> Post('pageUrl')
                    -> Validate('Regex', Cores\_Setting::_regexUrl)
                    -> Validate('Regex', Cores\_Setting::_regexPathUrl)
                  -> Post('controllerId')
                    -> Validate('Digit')
            ;

            // Parent ID
            $parentId = (empty($_POST['parentId']) ? 0 : $_POST['parentId']);

            $form -> Input('parentId', $parentId)
                    -> Validate('Regex', Cores\_Setting::_regexNumberic);

            // Password
            if (!empty($_POST['pagePassword'])){
                if ($_POST['pagePassword'] == "^Delete"){
                    $form -> Input('password', $_POST['pagePassword']);
                }else{
                    $form -> Input('password', $_POST['pagePassword'])
                        -> Validate('Regex', Cores\_Setting::_regexGerneral255);
                }
            }
            
            $form -> Submit();
            $data = $form -> Fetch();

            // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Insert New Page', implode(", ",$data));
            echo $this -> model -> Run($data);
            // Log Success
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Insert New Page SUCCESS', implode(", ",$data));
        }catch (\Exception $e){
            // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Insert New Page FAIL', "\nError:\n".$e -> getMessage());
            (new Cores\_Error) -> ShowError($e -> getMessage());
        }
    }
    
    // Delete Page
    function POSTDeletePage(){
        try{
            $form = new Cores\_Form;
            $form -> Post('functionId')
                  -> Validate('Digit');
            $form -> Submit();
            $data = $form -> Fetch();
            // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Delete Page', implode(", ",$data));
            echo $this -> model -> DeletePage($data['functionId']);
        }catch (\Exception $e){
            // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Delete Page FAIL', "\nError:\n".$e -> getMessage());
            (new Cores\_Error) -> ShowError($e -> getMessage());
        }   
    }

    // Inside
    // [PartialView]
    function GETPageGroupPermission($param){
        // Store Params
        Cores\_Session::Set('PageGroupPerm-FunctionId', $param['PageId']);
        $this -> view -> js = array(
            Cores\_Site::GetUrl().'views/admin/partial/page/js/page-group-permission.js'
        );
        $this -> view -> Render ('admin/partial/page/page-group-permission', null, null, true);
    }

    // [PartialView]
    function GETJSONPagesPermissionTable(){
        // Get Session FunctionId
        $functionId = Cores\_Session::Get('PageGroupPerm-FunctionId'); // Go inside model
        // TODO: Check different if not stay back
        $data = $this -> model -> GetPageGroupPermission($functionId);
        $data = json_encode($data);
        $this -> view -> Content($data);
    }
    
    // [PartialView] Get Form to Add New Group to page
    function FORMAddNewGroupToPage(){
        $this -> view -> js = array(
             Cores\_Site::GetUrl().'views/admin/partial/page/js/data-select2-addnewgroup.js'
        );
        $this -> view -> Render('admin/partial/page/add-new-group-to-page-form', null, null, true);
    }

    // [HTTP-POST]
    function POSTAddNewGroupToPage(){
        try{
            $form = new Cores\_Form;
            $form -> Post('groupId')
                    -> Validate('Digit');
            $form -> Submit();
            $data = $form -> Fetch();
            echo $this -> model -> AllowThisGroupToGetPerm($data['groupId'], Cores\_Permission::Read);
            // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Post POSTAddNewGroupToPage Success', implode(", ",$data));
            $this -> model -> RefreshUser();
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Refresh User', implode(", ",$data));
        }catch (\Exception $e){
            // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Post POSTAddNewGroupToPage FAIL', "\nError:\n".$e -> getMessage());
            (new Cores\_Error) -> ShowError($e -> getMessage());
        }
    }
    
    // Set Function Perm for Group
    function POSTSetFuncGroupPerm(){
        try{
            $form = new Cores\_Form;
            $form -> Post('groupId')
                  -> Validate('Digit')
                  -> Post('permissionValue')
                  -> Validate('Digit') 
                  ;
            $form -> Submit();
            $data = $form -> Fetch();
            echo $this -> model -> AllowThisGroupToGetPerm($data['groupId'], $data['permissionValue']);
            // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Post POSTSetFuncGroupPerm Success', implode(", ",$data));
            $this -> model -> RefreshUser();
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Refresh User', implode(", ",$data));
        }catch (\Exception $e){
            // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Failed to set permission for group', "\nError:\n".$e -> getMessage());
            (new Cores\_Error) -> ShowError($e -> getMessage());
        }
    }

    // Delete Function Perm of Group
    function POSTDeleteFuncGroupPerm(){
        try{
            $form = new Cores\_Form;
            $form -> Post('groupId')
                  -> Validate('Digit')
                  -> Post('permissionValue')
                  -> Validate('Digit') 
                  ;
            $form -> Submit();
            $data = $form -> Fetch();
            echo $this -> model -> RemoveThisGroupToGetPerm($data['groupId'], $data['permissionValue']);
            // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Delete permission of group successful', implode(", ",$data));
            $this -> model -> RefreshUser();
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Refresh User', implode(", ",$data));
        }catch (\Exception $e){
            // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Failed to delete permission of group', "\nError:\n".$e -> getMessage());
            (new Cores\_Error) -> ShowError($e -> getMessage());
        }
    }

    // [PartialView]
    function GETJSONAllGroupThatIsNotCurrentlyInPage(){
        try{
            $form = new Cores\_Form;
            $form -> Post('requestParam') -> Validate('Regex', Cores\_Setting::_regexGerneral) -> Submit();
            $data = $form -> Fetch();
            // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Posted Group Name', implode(", ",$data));
            $data = $this -> model -> GetSearchingGroupCurrentlyNotInPage($data['requestParam']);
            $this -> view -> Content(json_encode($data));
        }catch (\Exception $e){
             // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Get Data From GETJSONAllGroupThatIsNotCurrentlyInPage FAIL', "\nError:\n".$e -> getMessage());
            (new Cores\_Error) -> ShowError($e -> getMessage());
        }
    }

    // [PartialView]
    function FORMGroupPagePermission($param){
        $key = Cores\_Security::DecryptObject($param['key']);
        $this -> view -> page = $key['FunctionId'];
        $this -> view -> group = $key['GroupId'];
        $totalPermission = $this -> model -> GetTotalPermissionOfGroup($key['GroupId']);
        $this -> view -> data = $this -> model -> GetThisGroupPermission($totalPermission);
        $this -> view -> permissionData = Cores\_Site::GetConst('PHPEasy\Cores\_Permission');
        $this -> view -> js = array(
            Cores\_Site::GetUrl().'views/admin/partial/page/js/show-page-group-permission.js'
        );
        $this -> view -> Render('admin/partial/page/show-page-group-permission', null, null, true);
    }

    // [PartialView]
    function POSTAvailableController(){
        try{
            // Form to Validate
            $form = new Cores\_Form;
            $form -> Post('requestParam')
                    -> Validate('Regex', Cores\_Setting::_regexGerneral);
            $form -> Submit();
            $data = $form -> Fetch();
            // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Try to get controller\'s name', $data['requestParam']);
            // Init Model
            $ajax = $this -> model -> GetSearchingController($data['requestParam']);
            // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Request successful Controller Name', json_encode($ajax));
            // Render Content
            $this -> view -> Content(json_encode($ajax));
        }catch (\Exception $e){
            // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Get Controller FAIL', "\nError:\n".$e -> getMessage());
            (new Cores\_Error) -> ShowError($e -> getMessage());
        }
    }

    // Delete Group from Page permission
    function POSTDeleteGroupPagePermission(){
        try{
            $form = new Cores\_Form;
            $form -> Post('groupId')
                    -> Validate('Digit')
                  -> Input('functionId', Cores\_Session::Get('PageGroupPerm-FunctionId'))
                    -> Validate('Digit')
                  -> Submit();
            $data = $form -> Fetch();
            $result = $this -> model -> DeleteGroupPagePermission($data);
            echo $result;
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('POSTDeleteGroupPagePermission Success', "\nResult:\n".$result);
        }catch(\Exception $e){
             // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Delete From POSTDeleteGroupPagePermission FAIL', "\nError:\n".$e -> getMessage());
            (new Cores\_Error) -> ShowError($e -> getMessage());
        }
    }

    function Cms($param){      
        $model = array(
			'../ModelName' => 'page/cms', 
			'ModelPath' => 'models/admin/partial/sitemap/', // Always has last slash models/test (/) <- Important
			'ModelNameSpace' => '\\Admin\\Page'
		);
		$this -> LoadPartialController($param, 'controllers/admin/partial/sitemap/page/cms', __METHOD__, $model);
    }
    
    // [PartialView]
    function POSTAvailablePage(){
        try{
            // Form to Validate
            $form = new Cores\_Form;
            $form -> Post('requestParam')
                    -> Validate('Regex', Cores\_Setting::_regexGerneral255);
            $form -> Submit();
            $data = $form -> Fetch();
            // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Try to get controller\'s name', $data['requestParam']);
            // Init Model
            $ajax = $this -> model -> GetSearchingPage($data['requestParam']);
            // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Request successful Controller Name', json_encode($ajax));
            // Render Content
            $this -> view -> Content(json_encode($ajax));
        }catch (\Exception $e){
            // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Get Controller FAIL', "\nError:\n".$e -> getMessage());
            (new Cores\_Error) -> ShowError($e -> getMessage());
        }
    }

    // Sitemap
    function Sitemap(){
        $this -> view -> data = $this -> model -> GenerateSitemap();
        $this -> view -> Render ('admin/partial/page/sitemap', null, null, true);
    }
}
?>