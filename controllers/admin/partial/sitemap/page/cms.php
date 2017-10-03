<?php
namespace PHPEasy\Controllers\Admin\Page;
use PHPEasy\Cores as Cores;
use PHPEasy\Controllers as Controllers;

class Cms extends Controllers\Admin\Page{
    function __construct(){
		parent::__construct();
	}

    function Index($param){
       // Store Params
        Cores\_Session::Set('PageContent-PageId', $param['PageId']);
        $this -> view -> js = array(
            Cores\_Site::GetUrl().'views/cms/partial/cms/js/cms-load-default.js'
        );
        $this -> view -> Render ('cms/partial/cms/cms-page', null, null, true);
    }

    function GETJSONPageContentTable(){
        // Get Session FunctionId
        $pageId = Cores\_Session::Get('PageContent-PageId'); // Go inside model
        // TODO: Check different if not stay back
        $data = $this -> model -> GetPageContent($pageId);
        $data = json_encode($data);
        $this -> view -> Content($data);
    }

    function FORMAddUpdatePageContent($param){
       
        try{
            $pageStageId = preg_replace('/\s+/', '', $param['PageStageId']);
            Cores\_Session::Set('PageContent-PageStageId', $pageStageId);
            if (!empty($pageStageId) || $pageStageId != 0){
                $form = new Cores\_Form;
                $form -> Input('pageStageId', $pageStageId) 
                      -> Validate('Digit') 
                      -> Input('pageId', Cores\_Session::Get('PageContent-PageId'))
                      -> Validate('Digit') 
                      -> Submit();
                $data = $form -> Fetch();
                $getData = $this -> model -> GetDataPageContent($data);
                if ($getData !== null){
                    $this -> view -> data = $getData;
                }
            }

            $getLanguage = $this -> model -> GetLanguage();
            $this -> view -> language = $getLanguage;

            $this -> view -> js = array(
                Cores\_Site::GetUrl().'views/cms/partial/cms/js/add-update-form-page-content.js'
            );
            $this -> view -> render ('cms/partial/cms/add-update-cms', null, null, true);
        }catch (\Exception $e){
            (new Cores\_Error) -> ShowError($e -> getMessage());
        }
    }

    function POSTAddUpdatePageContent(){
        try{
            $form = new Cores\_Form;
            $form -> Input('StageName', $_POST['stageName']) 
                    -> Validate('Regex', Cores\_Setting::_regexGerneral)
                  -> Input('StageDescription', $_POST['description'])
                    -> Validate('Regex', Cores\_Setting::_regexGerneral255)
                  -> Input('LanguageId', $_POST['language'])
                    -> Validate('Digit')  
                  -> Input('CreatedBy', Cores\_Session::Get('loggedUser') -> id)
                    -> Validate('Digit')
                  -> Input('FunctionId', Cores\_Session::Get('PageContent-PageId'))
                    -> Validate('Digit');

            if (Cores\_Session::Get('PageContent-PageStageId') != null){
            $form -> Input('FunctionStageId', Cores\_Session::Get('PageContent-PageStageId'))
                    -> Validate('Digit');
            }

            if (isset($_POST['hide'][0])){
                $form -> Input('HideNavigationBar', $_POST['hide'][0])
                    -> Validate('Digit');
            }else{
                $form -> Input('HideNavigationBar', 0);
            }

            if (isset($_POST['hide'][1])){
            $form -> Input('HideFooter', $_POST['hide'][1])
                    -> Validate('Digit');
            }else{
                $form -> Input('HideFooter', 0);
            }
            
            if (isset($_POST['navigation'][0])){
                $form -> Input('NavbarConfig', $_POST['navigation'][0])
                    -> Validate('Digit');
            }else{
                $form -> Input('NavbarConfig', 0);
            }
                
            if (isset($_POST['navigation'][1])){
                $form -> Input('NavbarTransparent', $_POST['navigation'][1])
                    -> Validate('Digit');
            }else{
                $form -> Input('NavbarTransparent', 0);
            }
            
            $form -> Submit();

            $data = $form -> Fetch();
            
            $this -> view -> content($this -> model -> Run($data));
        }catch (\Exception $e){
            (new Cores\_Error) -> ShowError($e -> getMessage());
        }
    }

    function POSTDeletePageContent(){
        try{
            $form = new Cores\_Form;
            $form -> Post('FunctionStageId')
                  -> Validate('Digit');
            $form -> Submit();
            $data = $form -> Fetch();
            // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Delete Page Content', implode(", ",$data));
            $this -> view -> content( $this -> model -> DeletePageContent($data['FunctionStageId']));
        }catch (\Exception $e){
            // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Delete Page Content FAIL', "\nError:\n".$e -> getMessage());
            (new Cores\_Error) -> ShowError($e -> getMessage());
        }   
    }

    function POSTApplyPageContent(){
        try{
            $form = new Cores\_Form;
            $form -> Post('FunctionStageId')
                  -> Validate('Digit');
            $form -> Submit();
            $data = $form -> Fetch();
            // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Apply Page Content', implode(", ",$data));
            $this -> view -> content( $this -> model -> ApplyPageContent($data['FunctionStageId']));
        }catch (\Exception $e){
            // Log
            (new Cores\_Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Apply Page Content FAIL', "\nError:\n".$e -> getMessage());
            (new Cores\_Error) -> ShowError($e -> getMessage());
        }  
    }

    function QUICKGETFunctionId(){
        $this -> view -> Content(Cores\_Session::Get('PageContent-PageId'));
    }

    // function EditPage($param){ 
    //     if ($this -> page -> permission -> Get(Cores\_Permission::Edit) == true){
    //         try{
    //             $form = new Cores\_Form;
    //             $form -> Input('pageUrl', $param["url"]) 
    //                   -> Validate('Regex', Cores\_Setting::_regexPathUrlPass) 
    //                   -> Submit();
    //             $data = $form -> Fetch();
    //             $data['pageUrl'] = str_replace('-', '/', $data['pageUrl']);
                
    //             // Get page Info to edit
    //             $getPage = $this -> model -> GetPageInfo($data['pageUrl']);
    //             $getPage = (new Cores\_Array($getPage)) -> FlattenArray();
    //             // Fetch to content
    //             $this -> view -> cms -> content -> code = html_entity_decode ($getPage[6]);
                
    //             // Render View
    //             $this -> view -> css = array(
    //                 Cores\_Site::GetUrl().'views/cms/css/keditor-1.1.4.min.css',
    //                 Cores\_Site::GetUrl().'views/cms/css/keditor-components-1.1.4.min.css',
    //                 Cores\_Site::GetUrl().'views/cms/css/custom.css'
    //             );
    //             $this -> view -> js = array(

                    
    //                 Cores\_Site::GetUrl().'views/cms/plugins/jquery-ui-1.11.4/jquery-ui.min.js',
    //                 Cores\_Site::GetUrl().'views/cms/plugins/jquery.nicescroll-3.6.6/jquery.nicescroll.min.js',
    //                 Cores\_Site::GetUrl().'views/cms/plugins/ckeditor-4.5.6/ckeditor.js',
    //                 Cores\_Site::GetUrl().'views/cms/plugins/ckeditor-4.5.6/adapters/jquery.js',
    //                 Cores\_Site::GetUrl().'views/cms/js/keditor-1.1.4.min.js',
    //                 Cores\_Site::GetUrl().'views/cms/js/keditor-components-1.1.4.min.js',
    //                 Cores\_Site::GetUrl().'views/cms/js/default.private.admin.page.cms.js'

    //             );
    //             $this -> view -> title = "Edit Page Title: $getPage[7]";
    //             $this -> view -> render('cms/index');
    //         }catch(\Exception $e){
    //             $this -> view -> content($e -> getMessage());
    //         }
    //     }else{
    //         header('Location: /error/error403');
    //         exit();
    //     }        
    // }

    function GETINFOToEditPage($param){
        // DO POST
         if ($this -> page -> permission -> Get(Cores\_Permission::Edit) == true){
            try{
                $form = new Cores\_Form;
                $form -> Input('FunctionId', Cores\_Session::Get('PageContent-PageId')) 
                      -> Validate('Digit')
                      -> Input('FunctionStageId', $param['ContentId'])
                      -> Validate('Digit') 
                      -> Submit();
                $data = $form -> fetch();

                // Cores\_Session::Set('PageContent-PageStageId', $data['FunctionStageId']);

                // Make sure they have permission to edit page
                $url = $this -> model -> GetPageUrl($data);
                $url = $url['PageUrl'];

                $targetPage = new Cores\_Page($url, false);
                new Cores\_Auth($targetPage, false);

                // Check if permission to access or not
                if ($targetPage -> permission -> Get(Cores\_Permission::Edit)){
                    $this -> view -> title = $targetPage -> pageName;

                    // Get Content Page
                    $getContent = $this -> model -> GetPageContentToEdit($data);

                    $this -> view -> cms -> content -> code = html_entity_decode ($getContent['Content']);

                    // Navigation Bar Config
                    $this->view->navbar->IsHide = $getContent['HideNavigationBar'];
                    $this->view->navbar->config = $getContent['NavbarConfig'];
                    $this->view->navbar->transparent = $getContent['NavbarTransparent'];
                    // Footer Bar
                    $this->view->footer->IsHide = $getContent['HideFooter'];

                    // 
                    $this->view->stageId = $data['FunctionStageId'];

                    /** Update new way to get content need check
                    // $getContent = $this -> model -> GetPageContentToEdit($data);
                    // $this -> view -> title = $getContent[0]['StageName'];
                    // $this -> view -> cms -> content -> code = html_entity_decode ($getContent[0]['Content']);
                    */

                    // Render View
                    $this -> view -> css = array(
                        Cores\_Site::GetUrl().'views/cms/css/keditor-1.1.4.min.css',
                        Cores\_Site::GetUrl().'views/cms/css/keditor-components-1.1.4.min.css'
                    );
                    $this -> view -> js = array(

                        
                        Cores\_Site::GetUrl().'views/cms/plugins/jquery-ui-1.11.4/jquery-ui.min.js',
                        Cores\_Site::GetUrl().'views/cms/plugins/jquery-ui.touch-punch-0.2.3/jquery.ui.touch-punch.min.js',
                        Cores\_Site::GetUrl().'views/cms/plugins/jquery.nicescroll-3.6.6/jquery.nicescroll.min.js',
                        // Cores\_Site::GetUrl().'views/cms/plugins/ckeditor-4.5.6/ckeditor.js',
                        // Cores\_Site::GetUrl().'views/cms/plugins/ckeditor-4.5.6/adapters/jquery.js',
                        Cores\_Site::GetUrl().'views/cms/plugins/ckeditor-4.7.1/ckeditor.js',
                        Cores\_Site::GetUrl().'views/cms/plugins/ckeditor-4.7.1/adapters/jquery.js',
                        Cores\_Site::GetUrl().'views/cms/js/keditor-1.1.4.js',
                        Cores\_Site::GetUrl().'views/cms/js/keditor-components-1.1.4.js',
                        Cores\_Site::GetUrl().'views/cms/js/default.private.admin.page.cms.js'

                    );

                    $this -> view -> render('cms/index');
                }else{
                    goto error403;
                }
            }catch (\Exception $e){
                echo $e -> GetMessage();
            }
        }else{
            error403: 
            header('Location: /error/error403');
            exit();
        }        
    }

    function POSTContent(){
        try{
            $content = $_POST['data'];
            // Clean
            $content = trim($content);
            $content = stripslashes($content);
            $content = htmlentities($content);
            
            // Form
            $form = new Cores\_Form;
            $form -> Input('Content', $content)
                -> Input('FunctionStageId', $_POST['stageId'])
                    -> Validate('Digit')
                -> Input('Apply', $_POST['apply'])
                -> Submit();

            $data = $form -> fetch();
            
            $this -> view -> content($this -> model -> UpdatePageContent($data));
        }catch (\Exception $e){
            $this -> view -> content($e -> GetMessage());
        }
    }
}

?>