<?php
namespace PHPEasy\Models\Admin\Page;
use PHPEasy\Cores as Cores;
use PHPEasy\Models as Models;

class Cms extends Models\Admin\Page{
    private $_data = null;

    function GetPageInfo($pageUrl){
        $page = new Cores\_Page($pageUrl);
        return $page;
    }
    
    function GetPageContent($functionId){
        // Init
        $ajax = array();
        $data = array();
        $firstOnly = array();
        $queryString = "SELECT MAX(  `FunctionStageChangeLogId` ) AS  'FunctionStageChangeLogId'
                        FROM  `FunctionStage` a
                        LEFT JOIN  `FunctionStageChangeLog` b ON  `a`.`FunctionStageId` =  `b`.`FunctionStageId` 
                        LEFT JOIN  `User` c ON  `a`.`CreatedBy` =  `c`.`UserId` 
                        LEFT JOIN  `Language` d ON  `a`.`LanguageId` =  `d`.`LanguageId` 
                        WHERE  `a`.`FunctionId` =:functionId
                        GROUP BY  `a`.`LanguageId`
                        ORDER BY  `a`.`LanguageId` DESC";
        $arraySearch = array(":functionId" => $functionId);
        $getData = $this -> db -> Select($queryString, $arraySearch);
        foreach($getData as $returnData){
            $firstOnly[] = $returnData['FunctionStageChangeLogId'];
        }

        $queryString = "SELECT MAX(  `FunctionStageChangeLogId` ) AS  'FunctionStageChangeLogId',  `a`.`FunctionStageId` ,  `a`.`FunctionId` ,  `StageName` ,  `StageDescription` ,  `Email`, `LanguageName` 
                        FROM  `FunctionStage` a
                        LEFT JOIN  `FunctionStageChangeLog` b ON  `a`.`FunctionStageId` =  `b`.`FunctionStageId` 
                        LEFT JOIN  `User` c ON  `a`.`CreatedBy` =  `c`.`UserId` 
                        LEFT JOIN  `Language` d ON  `a`.`LanguageId` =  `d`.`LanguageId` 
                        WHERE  `a`.`FunctionId` =:functionId
                        GROUP BY  `a`.`LanguageId`, `a`.`FunctionStageId`
                        ORDER BY  `a`.`LanguageId` DESC, `a`.`FunctionStageId` DESC ";

        // $queryString = "SELECT * FROM (

                    //     SELECT MAX(  `FunctionStageChangeLogId` ) AS  'FunctionStageChangeLogId',  `a`.`FunctionStageId` ,  `a`.`FunctionId` ,  `StageName` ,  `StageDescription` ,  `Email`, `LanguageName` 
                    //     FROM  `FunctionStage` a
                    //     LEFT JOIN  `FunctionStageChangeLog` b ON  `a`.`FunctionStageId` =  `b`.`FunctionStageId` 
                    //     LEFT JOIN  `User` c ON  `a`.`CreatedBy` =  `c`.`UserId` 
                    //     LEFT JOIN  `Language` d ON  `a`.`LanguageId` =  `d`.`LanguageId` 
                    //     WHERE  `a`.`FunctionId` =:functionId
                    //     GROUP BY  `a`.`LanguageId`
                    //     ORDER BY  `a`.`LanguageId` DESC 
                    //     ) n

                    //     UNION ALL

                    //     SELECT * FROM (
                    //         SELECT MAX(  `FunctionStageChangeLogId` ) AS  'FunctionStageChangeLogId',  `a`.`FunctionStageId` ,  `a`.`FunctionId` ,  `StageName` ,  `StageDescription` ,  `Email`, `LanguageName` 
                    //         FROM  `FunctionStage` a
                    //         LEFT JOIN  `FunctionStageChangeLog` b ON  `a`.`FunctionStageId` =  `b`.`FunctionStageId` 
                    //         LEFT JOIN  `User` c ON  `a`.`CreatedBy` =  `c`.`UserId` 
                    //         LEFT JOIN  `Language` d ON  `a`.`LanguageId` =  `d`.`LanguageId` 
                    //         WHERE  `a`.`FunctionId` =:functionId
                    //         GROUP BY  `a`.`LanguageId`, `a`.`FunctionStageId`
                    //         ORDER BY  `a`.`LanguageId` DESC 
                    //     ) m WHERE `m`.`FunctionStageId` NOT IN (

                    //         SELECT `FunctionStageId` FROM (
                    //             SELECT MAX(  `FunctionStageChangeLogId` ) AS  'FunctionStageChangeLogId', `a`.`FunctionStageId`
                    //             FROM  `FunctionStage` a
                    //             LEFT JOIN  `FunctionStageChangeLog` b ON  `a`.`FunctionStageId` =  `b`.`FunctionStageId` 
                    //             LEFT JOIN  `User` c ON  `a`.`CreatedBy` =  `c`.`UserId` 
                    //             LEFT JOIN  `Language` d ON  `a`.`LanguageId` =  `d`.`LanguageId` 
                    //             WHERE  `a`.`FunctionId` =:functionId
                    //             GROUP BY  `a`.`LanguageId`
                    //             ORDER BY  `a`.`LanguageId` DESC 
                    //         ) o
                    //     )  
                    // ";
        $arraySearch = array(":functionId" => $functionId);
        $getData = $this -> db -> Select($queryString, $arraySearch);
        foreach ($getData as $returnData){
            foreach($returnData as $key => $value){
                $row[$key] = $value;
            }
            /* Edit HERE */
            $editActionColummn = '<a href="javascript:;" class="btn btn-sm btn-success" onclick="PHPEasy.Page.Sitemap.Admin.Pages.Page.CMS.Action().Edit('.$returnData['FunctionStageId'].')" data-toggle="tooltip" title="Edit Page Content Id: '.$returnData['FunctionStageId'].'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
            $deleteActionColumn = '<a href="javascript:;" class="btn btn-sm btn-danger" onclick="PHPEasy.Page.Sitemap.Admin.Pages.Page.CMS.Action().Delete('.$returnData['FunctionStageId'].')" data-toggle="tooltip" title="Delete Page Content Id: '.$returnData['FunctionStageId'].'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
            // $viewGroupColumn = '<a href="javascript:;" class="btn btn-sm btn-primary" onclick="PHPEasy.Page.Sitemap.Admin.Pages.Page.getPermissionGroup('.$returnData['FunctionId'].')" data-toggle="tooltip" data-html="true" title="View Group & Permission <br> Page Id: '.$returnData['FunctionId'].'"><i class="fa fa-lock" aria-hidden="true"></i></a>';
            $editPageColumn = '<a target="_blank" href="/admin/page/cms/GETINFOToEditPage/ContentId='.$returnData['FunctionStageId'].'" class="btn btn-sm btn-warning" data-toggle="tooltip" data-html="true" title="Edit Content Of Page Stage Id: '.$returnData['FunctionStageId'].'"><i class="fa fa-arrows" aria-hidden="true"></i></a>';
            if (in_array($returnData['FunctionStageChangeLogId'], $firstOnly) ){
                $applyActionColumn = '<a href="javascript:;" class="btn btn-sm btn-primary '.$i.'-'.$numOfLang.'" onclick="PHPEasy.Page.Sitemap.Admin.Pages.Page.CMS.Action().Apply('.$returnData['FunctionStageId'].')" data-toggle="tooltip" title="Apply Page Content Id: '.$returnData['FunctionStageId'].'"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a>';
            }else{
                $applyActionColumn = '<a href="javascript:;" class="btn btn-sm btn-primary" onclick="PHPEasy.Page.Sitemap.Admin.Pages.Page.CMS.Action().Apply('.$returnData['FunctionStageId'].')" data-toggle="tooltip" title="Apply Page Content Id: '.$returnData['FunctionStageId'].'"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a>';
            }
            $row["Action"] = ($returnData['FunctionId'] !== null) ? "<span class='pull-left'>".$applyActionColumn."</span><span class='pull-right'>".$viewGroupColumn.$editActionColummn.$deleteActionColumn.$editPageColumn."</span>" : null;
            $row["PageRowId"] = "page_".$returnData['FunctionId']."_stage_".$returnData['FunctionStageId'];

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

    function GetDataPageContent($pageParam){
        $queryString = 'SELECT * FROM `FunctionStage` a 
                        LEFT JOIN `Language` b ON `a`.`LanguageId` = `b`.`LanguageId`
                        WHERE `FunctionStageId` = :FunctionStageId AND `FunctionId` = :FunctionId';

        $data = $this -> db -> Select($queryString, array(
            ':FunctionStageId' => $pageParam['pageStageId'],
            ':FunctionId' => $pageParam['pageId']
        ), false);
        return $data;
    }

    function GetLanguage(){
        $queryString = 'SELECT * FROM `Language`';

        $data = $this -> db -> Select($queryString, array());
        return $data;
    }

    public function Run($data){
        $this -> _data = $data;
        if (empty($this -> _data['FunctionStageId'])){
            return $this -> AddNewPageContentInfo();
        }else{
            return $this -> UpdatePageContentInfo();
        }
    }

    private function AddNewPageContentInfo(){
        try{
            return $this -> db -> Insert('FunctionStage', $this -> _data, "SELECT `StageName` FROM `FunctionStage` WHERE `StageName` = :stageName AND `FunctionId` = :functionId", 
                array(
                    ":stageName" => $this -> _data['StageName'],
                    ":functionId" => $this -> _data['FunctionId']
                )
            );
        }catch (\Exception $e){
            return $e -> getMessage();
        }
    }

    private function UpdatePageContentInfo(){
        try{
            $checkIfExist = $this -> db -> Select("SELECT `StageName` FROM `FunctionStage` WHERE `FunctionStageId` <> :functionStageId AND `StageName` = :stageName AND `FunctionId` = :functionId", 
                array(
                    ":functionStageId" => $this -> _data['FunctionStageId'],
                    ":stageName" => $this -> _data['StageName'], 
                    ":functionId" => $this -> _data['FunctionId']
                )
            );

            $updateArray = array();
            foreach($this -> _data as $key => $value){
                $updateArray[$key] = $value;
            }

            if (count($checkIfExist) === 0){
                return $this -> db -> Update('FunctionStage', $updateArray, '`FunctionStageId` = :functionStageId', array(':functionStageId' => $this -> _data['FunctionStageId']));
            }
            return 'Stage Name is already exist!';
        }catch (\Exception $e){
            return $e -> getMessage();
        }
    }

    function DeletePageContent($functionStageId){
        // TODO: Record Delete or not ?
        try{
            $data = $this -> db -> Delete('DELETE FROM `FunctionStage` WHERE `FunctionStageId` = :FunctionStageId', array(':FunctionStageId' => $functionStageId));
            $data2 = $this -> db -> Delete('DELETE FROM `FunctionStageChangeLog` WHERE `FunctionStageId` = :FunctionStageId', array(':FunctionStageId' => $functionStageId));
            if (!$data  || !$data2){
                return 'Result Delete from `FunctionStage` Table: '. $data . ', from `FunctionStageChangeLog` Table: '. $data2.'.'; 
            }
            return true;
        }catch (\Exception $e){
            return $e -> getMessage();
        }
    }

    function ApplyPageContent($functionStageId){
        try{
            return $this -> db -> Insert('FunctionStageChangeLog', 
            array(
                "FunctionStageStatusId" => 3, 
                "FunctionStageId" => $functionStageId, 
                "CreatedBy" => Cores\_Session::Get('loggedUser') -> id
                )
            );
        }catch (\Exception $e){
            return $e -> getMessage();
        }
    }

    function GetPageContentToEdit($info){
        try{
            $queryString = "SELECT * FROM `FunctionStage` WHERE `FunctionId` = :functionId AND `FunctionStageId` = :functionStageId";
            $arraySearch = array(
                ":functionId" => $info['FunctionId'],
                ":functionStageId" => $info['FunctionStageId']
            );
            
            return $getData = $this -> db -> Select($queryString, $arraySearch, false);
        }catch (\Exception $e){
            return $e -> GetMessage();
        }
    }
    
    function UpdatePageContent($data){
        try{
            // Check Permission
            $returnData = $this -> db -> Select("SELECT `PageUrl` FROM `Function` a, `FunctionStage` b
                                           WHERE `a`.`FunctionId` = `b`.`FunctionId` AND `b`.`FunctionStageId` = :FunctionStageId            
            ", array(':FunctionStageId' => $data['FunctionStageId'])
            , false);
            
            $targetPage = new Cores\_Page($returnData['PageUrl'], false);
            new Cores\_Auth($targetPage, false);

            if ($targetPage -> permission -> Get(Cores\_Permission::Edit)){
                if ($data['Apply']){
                    $this -> ApplyPageContent($data['FunctionStageId']);
                }
                return $this -> db -> Update('FunctionStage', 
                                                            array(
                                                                'Content' => $data['Content'],
                                                            ), 
                                                            '`FunctionStageId` = :functionStageId', array(':functionStageId' => $data['FunctionStageId']));
            }else{
                throw new \Exception("You don't have permission to edit this page!");
            }
        }catch (\Exception $e){
            return $e -> GetMessage();
        }
    }

    function GetPageUrl($info){
        try{
            $queryString = "SELECT `PageUrl` FROM `Function` WHERE `FunctionId` = :functionId";
            $arraySearch = array(
                ":functionId" => $info['FunctionId']
            );
            
            return $getData = $this -> db -> Select($queryString, $arraySearch, false);
        }catch (\Exception $e){
            return $e -> GetMessage();
        }
    }
}
?>