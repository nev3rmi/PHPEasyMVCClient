<?php
namespace PHPEasy\Models\Admin;
use PHPEasy\Cores as Cores;
use PHPEasy\Models as Models;

class Page extends Models\Admin{
    function GetDataForPageTable(){
        // Init
        $ajax = array();
        $data = array();
        $queryString = "SELECT  `a`.`FunctionId` ,  `a`.`FunctionName` ,  `a`.`ControllerId` ,  `b`.`ControllerName`,  `a`.`ParentId` ,  `c`.`FunctionName` AS `ParentName`,  `c`.`PageUrl` AS  `ParentUrl`,  `a`.`PageUrl` 
                        FROM  `Function` a
                        RIGHT JOIN  `Controller` b ON  `a`.`ControllerId` =  `b`.`ControllerId` 
                        LEFT JOIN  `Function` c ON  `a`.`ParentId` =  `c`.`FunctionId`";
        $arraySearch = array();
        $getData = $this -> db -> Select($queryString, $arraySearch);
        foreach ($getData as $returnData){
            foreach($returnData as $key => $value){
                $row[$key] = $value;
            }
            /* Edit HERE */
            $editActionColummn = '<a href="javascript:;" class="btn btn-sm btn-success" onclick="PHPEasy.Page.Sitemap.Admin.Pages.Page.getFormToAddUpdatePage('.$returnData['FunctionId'].')" data-toggle="tooltip" title="Edit Page Id: '.$returnData['FunctionId'].'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
            $deleteActionColumn = '<a href="javascript:;" class="btn btn-sm btn-danger" onclick="PHPEasy.Page.Sitemap.Admin.Pages.Page.deletePage('.$returnData['FunctionId'].')" data-toggle="tooltip" title="Delete Page Id: '.$returnData['FunctionId'].'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
            $viewGroupColumn = '<a href="javascript:;" class="btn btn-sm btn-primary" onclick="PHPEasy.Page.Sitemap.Admin.Pages.Page.getPermissionGroup('.$returnData['FunctionId'].')" data-toggle="tooltip" data-html="true" title="View Group & Permission <br> Page Id: '.$returnData['FunctionId'].'"><i class="fa fa-lock" aria-hidden="true"></i></a>';
            $editPageColumn = '<a href="javascript:;" class="btn btn-sm btn-warning" onclick="PHPEasy.Page.Sitemap.Admin.Pages.Page.CMS.showListOfContent('.$returnData['FunctionId'].')" data-toggle="tooltip" data-html="true" title="Edit Content Of Page Id: '.$returnData['FunctionId'].'"><i class="fa fa-arrows" aria-hidden="true"></i></a>';
            $viewPageColumn = '<a data-view-page-id="'.$returnData['FunctionId'].'" href="'.$returnData['PageUrl'].'" target="_blank" class="btn btn-sm btn-info" data-toggle="tooltip" data-html="true" title="Go to Page Id: '.$returnData['FunctionId'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>';

            $row["Action"] = ($returnData['FunctionId'] !== null) ? $viewGroupColumn.$editActionColummn.$deleteActionColumn.$editPageColumn.$viewPageColumn : null;
            $row["PageRowId"] = "row_controller_".$returnData['ControllerId']."_page_".$returnData['FunctionId'];

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

    function GetData($functionId){
        $data = $this -> db -> Select(" SELECT  `a`.`FunctionId` ,  `a`.`FunctionName` ,  `a`.`ControllerId` ,  `b`.`ControllerName`,  `a`.`ParentId` ,  `c`.`FunctionName` AS `ParentName`,  `c`.`PageUrl` AS  `ParentUrl`,  `a`.`PageUrl`, `a`.`Password` 
                                        FROM  `Function` a
                                        JOIN  `Controller` b ON  `a`.`ControllerId` =  `b`.`ControllerId` 
                                        LEFT JOIN  `Function` c ON  `a`.`ParentId` =  `c`.`FunctionId`
                                        WHERE  `a`.`FunctionId` = :functionId
                                    ", array(":functionId" => $functionId), false);
        return $data;
    }

    function Run($data){
        // Parent of itself main no parent
        if($data['parentId'] == $data['functionId']){
            $data['parentId'] = 0;
        }

        $this -> _data = $data;
        if (empty($this -> _data['functionId'])){
            return $this -> AddNewPage();
        }else{
            return $this -> UpdatePage();
        }
    }
    
    // TODO: Need to make sure non of functionName or pageUrl exist before insert
    // Maybe: Insert('Function', $this->_data, 'SELECT * FROM `Function` WHERE `FunctionName` LIKE :functionName', array(':functionName' => 'NONE')) // Build Dynamiclly
    private function AddNewPage(){
        try{
            // Updated Time
            $this -> _data['UpdatedTime'] = $GLOBALS['_NOW_'] -> clockDateTime;
            // Encrypt Password
            if (!empty($this -> _data['password'])){
                if ($this -> _data['password'] == "^Delete"){
                    $this -> _data['password'] = "";
                }else{
                    $this -> _data['password'] = $GLOBALS['_Security'] -> HashKey($this -> _data['password']);
                    $this -> _data['password'] = $GLOBALS['_Security'] -> HashEncryptedWithSalt($this -> _data['password']);
                }
            }
            $this -> db -> Insert('Function', $this -> _data, "SELECT `FunctionName` FROM `Function` WHERE (`PageUrl` = :pageUrl OR `PageUrl` = :PageUrlIndex)", 
                array(
                    ":pageUrl" => $this -> _data['pageUrl'],
                    ":PageUrlIndex" => $this -> _data['pageUrl'].'/index'
                )
            );

            $lastId = $this -> db -> lastInsertId();

            $this -> db -> CreateObjectAcl('Function', $lastId, Cores\_Session::Get('loggedUser') -> id);
            return true;
        }catch (\Exception $e){
            return $e -> getMessage();
        }
        
    }
    private function UpdatePage(){
        try{
            $checkIfExist = $this -> db -> Select("SELECT `FunctionName` FROM `Function` WHERE `FunctionId` <> :functionId AND (`PageUrl` = :pageUrl OR `PageUrl` = :PageUrlIndex)", 
                array(
                    ":functionId" => $this -> _data['functionId'],
                    ":pageUrl" => $this -> _data['pageUrl'],
                    ":PageUrlIndex" => $this -> _data['pageUrl'].'/index'
                )
            );
            if (count($checkIfExist) === 0){
                $data = array(
                    'FunctionName' => $this -> _data['functionName'],
                    'ControllerId' => $this -> _data['controllerId'],
                    'PageUrl' => $this -> _data['pageUrl'],
                    'ParentId' => $this -> _data['parentId'],
                    'UpdatedTime' => $GLOBALS['_NOW_'] -> clockDateTime
                );

                // Encrypt Password
                if (!empty($this -> _data['password'])){
                    if ($this -> _data['password'] == "^Delete"){
                        $data['Password'] = "";
                    }else{
                        $data['Password'] = $GLOBALS['_Security'] -> HashKey($this -> _data['password']);
                        $data['Password'] = $GLOBALS['_Security'] -> HashEncryptedWithSalt($data['Password']);
                    }
                }

                return $this -> db -> Update('Function', $data, '`FunctionId` = :FunctionId', array(':FunctionId' => $this -> _data['functionId']));
            }
            return 'Function is already exist!';
        }catch (\Exception $e){
            return $e -> getMessage();
        }
    }

    function DeletePage($functionId){
        try{
            $data = $this -> db -> Delete('DELETE FROM `Function` WHERE `FunctionId` = :FunctionId', array(':FunctionId' => $functionId));
            $getObjectId = $this -> db -> GetObjectAcl('Function', $functionId);
            $data2 = $this -> db -> Delete('DELETE FROM `ACL` WHERE `ObjectId` = :ObjectId', array(':ObjectId' => $getObjectId));
            $this -> db -> DeleteObjectAcl('Function', $functionId);
            if (!$data  || !$data2){
                return 'Result Delete from `Function` Table: '. $data . ', from `ACL` Table: '. $data2.'.'; 
            }
            return true;
        }catch (\Exception $e){
            return $e -> getMessage();
        }
    }

    function GetPageGroupPermission($functionId){ 
          // Init
        $ajax = array();
        $data = array();
        // $queryString = "SELECT a.`FunctionId` , a.`GroupId` , b.`GroupName` , SUM(  `Value` ) AS  `TotalPermission` 
        //                 FROM  `FunctionPermission` a
        //                 JOIN  `Group` b ON a.`GroupId` = b.`GroupId` 
        //                 WHERE `a`.`FunctionId` = :functionId 
        //                 GROUP BY  `a`.`FunctionId` ,  `a`.`GroupId` ";
        $queryString = "SELECT `d`.`FunctionId` , `a`.`GroupId` , `b`.`GroupName` , SUM(  `Value` ) AS  `TotalPermission` 
                        FROM  `ACL` a
                        JOIN  `Group` b ON a.`GroupId` = b.`GroupId` 
                        JOIN `Object` c ON a.`ObjectId` = c.`ObjectId` AND c.`TableName` = 'Function'
                        JOIN `Function` d ON c.`PrimaryKey` = d.`FunctionId`
                        WHERE `d`.`FunctionId` = :functionId  
                        GROUP BY  `d`.`FunctionId` ,  `a`.`GroupId`";
        $arraySearch = array(":functionId" => $functionId);
        $getData = $this -> db -> Select($queryString, $arraySearch);
        foreach ($getData as $returnData){
            foreach($returnData as $key => $value){
                $row[$key] = $value;
            }
            /* Edit HERE */

            // Encrypt Data
            $generateKey = array(
                'FunctionId' => $returnData['FunctionId'],
                'GroupId' => $returnData['GroupId'],
                'TotalPermission' => $returnData['TotalPermission']
            );

            $permissionKey = Cores\_Security::EncryptObject($generateKey);

            $viewGroupColumn = '<a href="javascript:;" class="btn btn-sm btn-primary" onclick="PrivatePagePermission.getGroupPagePermission(\''.$permissionKey.'\')" data-toggle="tooltip" data-html="true" title="Edit Permission <br> Group Id: '.$returnData['GroupId'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>';
            $deleteActionColumn = '<a href="javascript:;" class="btn btn-sm btn-danger" onclick="PrivatePagePermission.deleteGroupPagePermission('.$returnData['GroupId'].')" data-toggle="tooltip" data-html="true" title="Delete Permission <br> Group Id: '.$returnData['GroupId'].'"><i class="fa fa-trash" aria-hidden="true"></i></a>';

            $row["Action"] =  $viewGroupColumn.$deleteActionColumn;
            $row["ControllerRowId"] = "row_".$returnData['FunctionId'];
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

    function AllowThisGroupToGetPerm($groupId, $permissionValue){
        try{

        }catch (\Exception $e){
            return $e -> getMessage();
        }
        $permissionConst = Cores\_Site::GetConst('PHPEasy\Cores\_Permission');
        $arrayFlipConst = array_flip($permissionConst);
        $functionId = Cores\_Session::Get('PageGroupPerm-FunctionId');
        $objectId = $this -> db -> GetObjectAcl('Function', $functionId);
        $data = array(
            'Name' => $arrayFlipConst[$permissionValue],
            'Description' => 'Allow Group '.$groupId.' to '.$arrayFlipConst[$permissionValue].' functionId '.$functionId,
            'GroupId' => $groupId,
            'ObjectId' => $objectId,
            'Value' => $permissionValue
        );
        $this -> db -> Insert('ACL', $data, array('GroupId', 'ObjectId', 'Value'), array(), array($groupId, $objectId, $permissionValue));
        return true;
    }

    function RemoveThisGroupToGetPerm($groupId, $permissionValue){
        try{
            $functionId = Cores\_Session::Get('PageGroupPerm-FunctionId');
            $objectId = $this -> db -> GetObjectAcl('Function', $functionId);
            $array = array(
                ':groupId' => $groupId,
                ':objectId' => $objectId,
                ':value' => $permissionValue
            );
            return $this -> db -> Delete('DELETE FROM `ACL` WHERE `GroupId` = :groupId AND `ObjectId` = :objectId AND `Value` = :value', $array);
        }catch (\Exception $e){
            return $e -> getMessage();
        }
        
    }

    function GetSearchingGroupCurrentlyNotInPage($param){
        // Log
        (new Cores\_Log("PHPEasy\Controllers", "PHPEasy\Controllers\Admin", "GETJSONAllGroupThatIsNotCurrentlyInPage")) -> WriteLog('Passed Param to Model: ', $param);
        // Get FunctionId
        $functionId = Cores\_Session::Get('PageGroupPerm-FunctionId');
        // Init
        $ajax = array();
        $data = array();
        $queryString = "SELECT * FROM `Group` a WHERE `GroupId` NOT IN (SELECT `GroupId` FROM `ACL` WHERE `ObjectId` = :objectId)";
        $arraySearch = array();
        $arraySearch[':objectId'] = $this -> db -> GetObjectAcl('Function', $functionId);
        if ($param !== 'All'){
            $queryString .= " AND `GroupName` LIKE :groupName";
            $arraySearch[':groupName'] = '%'.$param.'%';
        }
        $getData = $this -> db -> Select($queryString, $arraySearch);
        (new Cores\_Log("PHPEasy\Controllers", "PHPEasy\Controllers\Admin", "GETJSONAllGroupThatIsNotCurrentlyInPage")) -> WriteLog('Load Data in Model: ', json_encode($getData));
        foreach ($getData as $returnData){
            $data[] = array(
                "id" => $returnData['GroupId'],
                "text" => $returnData['GroupName']
            );
        }
       
        $ajax['items'] = $data;
        return $ajax;
    }

    function GetTotalPermissionOfGroup($groupId){
        $functionId = Cores\_Session::Get('PageGroupPerm-FunctionId');
        $array = array(
            ":groupId" => $groupId,
            ":objectId" => $this -> db -> GetObjectAcl('Function', $functionId)
        );
        $result = $this -> db -> Select(" SELECT SUM(`Value`) AS 'TotalPermission' 
                                FROM  `ACL` 
                                WHERE  `GroupId` = :groupId
                                AND  `ObjectId` = :objectId
                             ", $array, false);

        return $result['TotalPermission'];
    }

    function GetThisGroupPermission($key){
        $consts = Cores\_Site::GetConst('PHPEasy\Cores\_Permission');
        $result = array();

        $permission = new Cores\_Permission;
        $permission -> Set($key);

        foreach ($consts as $key => $value){
            $result[$key] = $permission -> Get($value);
        }

        return $result;
    }

    function GetSearchingController($param){
        // Log
        (new Cores\_Log("PHPEasy\Controllers", "PHPEasy\Controllers\Admin", "POSTAvailableController")) -> WriteLog('Passed Param to Model: ', $param);
        // Init
        $ajax = array();
        $data = array();
        $queryString = "SELECT * FROM `Controller`";
        $arraySearch = array();
        if ($param !== 'All'){
            $queryString .= " WHERE `ControllerName` LIKE :controllerName";
            $arraySearch = array(":controllerName" => '%'.$param.'%');
        }
        $getData = $this -> db -> Select($queryString, $arraySearch);
        (new Cores\_Log("PHPEasy\Controllers", "PHPEasy\Controllers\Admin", "POSTAvailableController")) -> WriteLog('Load Data in Model: ', json_encode($getData));
        foreach ($getData as $returnData){
            $data[] = array(
                "id" => $returnData['ControllerId'],
                "text" => $returnData['ControllerName']
            );
        }
       
        $ajax['items'] = $data;
        return $ajax;
    }

    function DeleteGroupPagePermission($data){
        try{
            $array = array(
                ':groupId' => $data['groupId'],
                ':objectId' => $this -> db -> GetObjectAcl('Function', $data['functionId'])
            );
            return $this -> db -> Delete('DELETE FROM `ACL` WHERE `GroupId` = :groupId AND `ObjectId` = :objectId ', $array);
        }catch (\Exception $e){
            return $e -> getMessage();
        }
    }

    function RefreshUser(){
        // Refresh
        $loggedUser = Cores\_Session::Get('loggedUser');
        $loggedUser -> SetPermission();
        Cores\_Session::Set('loggedUser', $loggedUser);
    }

    function GetSearchingPage($param){
        // Log
        (new Cores\_Log("PHPEasy\Controllers", "PHPEasy\Controllers\Admin", "POSTAvailablePage")) -> WriteLog('Passed Param to Model: ', $param);
        // Init
        $ajax = array();
        $data = array();
        $queryString = "SELECT * FROM `Function`";
        $arraySearch = array();
        if ($param !== 'All'){
            $queryString .= " WHERE (
                                `PageUrl` LIKE  :functionParam ESCAPE  '/'
                                    OR  `FunctionName` LIKE  :functionParam  ESCAPE  '/'
                                )
            ";
            $arraySearch = array(":functionParam" => '%'.$param.'%');
        }
        $getData = $this -> db -> Select($queryString, $arraySearch);
        
        (new Cores\_Log("PHPEasy\Controllers", "PHPEasy\Controllers\Admin", "POSTAvailablePage")) -> WriteLog('Load Data in Model: ', json_encode($getData));
        foreach ($getData as $returnData){
            $data[] = array(
                "id" => $returnData['FunctionId'],
                "text" => $returnData['PageUrl']
            );
        }

        $ajax['items'] = $data;
        return $ajax;
    }

    function GenerateSitemap(){
        // Get data
        $queryString = "SELECT * FROM `Function`";
        $getData = $this -> db -> Select($queryString);

        return $getData;
    }
}
?>