<?php
namespace PHPEasy\Cores;
class _Page extends _Sitemap{
    public $pageId = null;
    public $controllerId = null;
    public $pageUrl = null;
    public $pageFunction = null;
    public $pageParameter = null;
    public $pageContent = null;
    public $pageName = null;
    public $pageStageLogId = null;
    public $pageLanguage = null;
    // Page Meta
    public $pageTransparentNavbar = false;
    public $pageNavbarConfig = 0;
    public $pageDescription = null;
    public $pageAuthor = null;
    public $pagePublishedDate = null;
    public $pageHideNavBar = null;
    public $pageHideFooter = null;
    public $pagePassword = null;
    
    public function __construct($pageUrl = null, $session = true){
        // Extends from _Sitemap
        parent::__construct();
        // Get Document path
        $this -> _setPageUrl($pageUrl);
        // Connect to DB
        $this -> db = new _Database;
        // Set information
        $this -> SetPageInformation($this -> pageUrl);
        // Close DB Connection
        unset($this -> db);
        // Permission for page
        $this -> permission = new _Permission;
        // Import Page to Session
        if ($session){
            $this -> SetPageToSession();
        }
       // TODO: Implement store cookie
    }

    private function _setPageUrl($pageUrl){
        $this -> pageUrl = ($pageUrl != null)?$pageUrl:_Site::GetDocumentPath();
        if ($this -> pageUrl == null){
            $this -> pageUrl = "/index";
        }  
        return $this;
    }

    function SetPageInformation($pageUrl){
        // Set Variable
        $pageRealUrl = $pageUrl;
        // Set Language
        if (_Session::Get('Language') == null){
            _Session::Set('Language', new _Language);
        }
        // Explode URL
        $explodePageUrl = explode('/', $pageUrl);
        $string = array();
        $matchUrl = null;

        for($x = 1; $x < count($explodePageUrl); $x++){
            if (isset($explodePageUrl[$x])){
                if (!isset($string[$x - 1])){
                    $string[$x - 1] = null;
                }
                $string[$x] = $string[$x - 1].'/'.$explodePageUrl[$x];
            }

            $regexString = '/^'.str_replace('/','\/',$string[$x]).'$/';
            $regexStringIndex = '/^'.str_replace('/','\/',$string[$x]).'\/index$/';

            if (!empty(preg_grep($regexString, $this -> sitemapMatchingData))){
                $matchUrl[$x] = preg_grep($regexString, $this -> sitemapMatchingData);
            }else if(!empty(preg_grep($regexStringIndex, $this -> sitemapMatchingData))){
                $matchUrl[$x] = preg_grep($regexStringIndex, $this -> sitemapMatchingData);
            }
        }

        $data = (end($matchUrl));
        $result = array_intersect($data,$string);
        if (count($data) > 0 && $result != null){

            $functionId = array_keys($data)[0];
            $pageUrl = array_values($data)[0];
            $maxKeyInData = max(array_keys($result));
            $pageFunction = end(explode("/", $data[$maxKeyInData]));
            $pageParamDiff = array_diff($string, $data);

            foreach ($pageParamDiff as $key => $value){
                $pageParamGet[$key] = explode("/", $value);
                $pageParam[] = $pageParamGet[$key][$key];
            }

            $query = "SELECT `b`.`ControllerId`, `b`.`ControllerName`, `a`.`FunctionName`, `c`.`FunctionStageId`, `c`.`LanguageId`, MAX(`d`.`FunctionStageChangeLogId`) AS 'FunctionStageChangeLogId', `NavbarTransparent`, `NavbarConfig`, `StageDescription`, `FirstName`, `UpdateTime`, `HideNavigationBar`, `HideFooter`, `Content`, `a`.`Password` AS 'SitePassword'
                      FROM `Function` a
                      JOIN `Controller` b ON `a`.`ControllerId` = `b`.`ControllerId`
                      LEFT JOIN `FunctionStage` c ON `a`.`FunctionId` = `c`.`FunctionId`
                      LEFT JOIN `FunctionStageChangeLog` d ON `c`.`FunctionStageId` = `d`.`FunctionStageId`
                      LEFT JOIN `User`e ON `c`.`CreatedBy` = `e`.`UserId`
                      WHERE `a`.`FunctionId` = :functionId
                      GROUP BY `c`.`FunctionStageId`, `c`.`LanguageId`
                      ORDER BY `c`.`LanguageId` ASC";
            $content = $this -> db -> Select($query, array(
                    ':functionId' => $functionId
            ));

            $contentCode = null;

            // Put content to category by language.
            foreach ($content as $key => $value)
            {
                $contentCode[(empty($value['LanguageId'])?0:$value['LanguageId'])] = $value; 
            }

            if (empty($contentCode[0])){
                $callLanguage = _Session::Get('Language') -> id;
            }else{
                $callLanguage = 0;
            }

            if (!empty($content)){
                // Set Page Content
                $this -> pageStageLogId = $contentCode[$callLanguage]['FunctionStageChangeLogId'];
                $this -> pageContent = $contentCode[$callLanguage]['Content'];
                $this -> pageTransparentNavbar = $contentCode[$callLanguage]['NavbarTransparent'];
                $this -> pageNavbarConfig = $contentCode[$callLanguage]['NavbarConfig'];
                $this -> pageDescription = $contentCode[$callLanguage]['StageDescription'];
                $this -> pageHideNavBar = $contentCode[$callLanguage]['HideNavigationBar'];
                $this -> pageHideFooter = $contentCode[$callLanguage]['HideFooter'];
                $this -> pageAuthor = $contentCode[$callLanguage]['FirstName'];
                $this -> pagePublishedDate = $contentCode[$callLanguage]['UpdateTime'];
                $this -> controllerId = $contentCode[$callLanguage]['ControllerId'];
                $this -> pageName = $contentCode[$callLanguage]['FunctionName'];
                $this -> controllerName = $contentCode[$callLanguage]['ControllerName'];
                $this -> pagePassword = $contentCode[$callLanguage]['SitePassword'];
            }else{
                $this -> pageTransparentNavbar = false;
                $this -> pageNavbarConfig = 0;
                $this -> pageHideNavBar = false;
                $this -> pageHideFooter = false;
            }
            // Set Data
            $this -> pageId = $functionId;
            $this -> pageUrl = $pageUrl;
            $this -> pageFunction = $pageFunction;
            $this -> pageParameter = $pageParam;
            $this -> pageLanguage = _Session::Get('Language');

            // Return
            return $this;
        }

        // Page Not Found
        if (_Setting::_switchSecurity || _Setting::_switchSecurity === 1){
            header("Location: "._Site::GetUrl()."error/error404");
            exit;
        }
    }
   
    private function AutoRecordNewPage(){
        // page different admin auto view for AllUsers = 1
    }

    public function SetPageToSession(){
        _Session::Init();
        _Session::Set('page', $this);
    }
}
?>