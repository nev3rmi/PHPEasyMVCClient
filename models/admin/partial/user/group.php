<?php
namespace PHPEasy\Models\Admin;
use PHPEasy\Cores as Cores;
use PHPEasy\Models as Models;

class Group extends Models\Admin{
    public function GetGroup(){
        $queryString = "SELECT * FROM `Group`";
        $datas = $this -> db -> Select($queryString);
        foreach ($datas as $returnData){
            foreach($returnData as $key => $value){
                $row[$key] = $value;
            }

            /* Edit HERE */
            $editActionColummn = '<a href="javascript:;" class="btn btn-sm btn-success" onclick="PHPEasy.Page.Sitemap.Admin.Group.Action().Edit('.$returnData['GroupId'].')" data-toggle="tooltip" title="Edit Group Id: '.$returnData['GroupId'].'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
            $deleteActionColumn = '<a href="javascript:;" class="btn btn-sm btn-danger" onclick="PHPEasy.Page.Sitemap.Admin.Group.Action().Delete('.$returnData['GroupId'].')" data-toggle="tooltip" title="Delete Group Id: '.$returnData['GroupId'].'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
            $viewGroupColumn = '<a href="javascript:;" class="btn btn-sm btn-primary" onclick="PHPEasy.Page.Sitemap.Admin.Group.Manage.People.View('.$returnData['GroupId'].')" data-toggle="tooltip" data-html="true" title="View People in Group Id: '.$returnData['GroupId'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>';
          
            $row["Action"] = ($returnData['GroupId'] !== null) ? $viewGroupColumn.$editActionColummn.$deleteActionColumn : null;
            $row["PageRowId"] = "row_group_".$returnData['GroupId'];

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
    public function Run($data){
        $this -> _data = $data;
        if (empty($this -> _data['groupId'])){
            return $this -> AddNewGroup();
        }else{
            return $this -> UpdateGroup();
        }
    }
    private function AddNewGroup(){ // Need to fix bug
        try{
            return $this -> db -> Insert('Group', $this -> _data, "SELECT `GroupName` FROM `Group` WHERE `GroupName` = :groupName", 
                array(
                    ":groupName" => $this -> _data['groupName']
                )
            );
        }catch (\Exception $e){
            return $e -> getMessage();
        }
    }

    private function UpdateGroup(){
        try{
            $checkIfExist = $this -> db -> Select("SELECT `GroupName` FROM `Group` WHERE `GroupId` <> :groupId AND `GroupName` = :groupName", 
                array(
                    ":groupId" => $this -> _data['groupId'],
                    ":groupName" => $this -> _data['groupName'], 
                )
            );
            if (count($checkIfExist) === 0){
                return $this -> db -> Update('Group', 
                                                        array(
                                                            'GroupName' => $this -> _data['groupName'],
                                                            'GroupDescription' => $this -> _data['groupDescription'],
                                                        ), 
                                                        '`GroupId` = :groupId', array(':groupId' => $this -> _data['groupId']));
            }
            return 'Group Name is already exist!';
        }catch (\Exception $e){
            return $e -> getMessage();
        }
    }

    function GetData($groupId){
        $queryString = 'SELECT `GroupName`, `GroupDescription` FROM `Group` WHERE `GroupId` = :groupId';

        $data = $this -> db -> Select($queryString, array(
            ':groupId' => $groupId
        ), false);
        return $data;
    }

    function DeleteGroup($groupId){
        try{
            // Make sure there is no Function Exist before delete `Controller`
            $selectController = $this -> db -> Select('SELECT `UserId` FROM `UserInGroup` WHERE `GroupId` = :GroupId', array(
                ':GroupId' => $groupId
            ));
            if (count($selectController) > 0){
                return 'Cannot delete this group because, '.count($selectController).' user'.(count($selectController) > 1?'s':'').' exist in this group.<br> Please unlink all users before delete this group.';
            }

            $data = $this -> db -> Delete('DELETE FROM `Group` WHERE `GroupId` = :GroupId', array(':GroupId' => $groupId));

            return $data;
        }catch (\Exception $e){
            return $e -> getMessage();
        }
    }

    function GetUserInGroup($groupId){
        // Init
        $ajax = array();
        $data = array();
        $queryString = "
        SELECT `b`.`Email`, `b`.`UserId` 
        FROM  `UserInGroup` a,  `User` b
        WHERE  `a`.`UserId` =  `b`.`UserId` 
        AND `a`.`GroupId` = :groupId AND `a`.`UserId` != 1
        ";
        $arraySearch = array(
            ":groupId" => $groupId
        );
        $getData = $this -> db -> Select($queryString, $arraySearch);
        foreach ($getData as $returnData){
            foreach($returnData as $key => $value){
                $row[$key] = $value;
            }
            /* Edit HERE */
            // $editActionColummn = '<a href="javascript:;" class="btn btn-sm btn-success" onclick="GetFormToAddUpdateController('.$returnData['ControllerId'].')" data-toggle="tooltip" title="Edit Controller Id: '.$returnData['ControllerId'].'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
            $deleteActionColumn = '<a href="javascript:;" class="btn btn-sm btn-danger" onclick="PHPEasy.Page.Sitemap.Admin.Group.UserInGroup.Action().Delete('.$returnData['UserId'].')" data-toggle="tooltip" title="Remove User Id: '.$returnData['UserId'].'"><i class="fa fa-trash" aria-hidden="true"></i></a>';

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

    function GetUserNOTInGroup($dataToSearch){
        // Init
        $ajax = array();
        $data = array();
        $arraySearch = array();
        
        $groupId = Cores\_Session::Get("CurrentUserInGroup");
        $infoToSearch = $dataToSearch['requestParam'];

        if ($infoToSearch == "All"){
            $queryString = "SELECT `UserId`,`Email`
                            FROM `User` WHERE `UserId` NOT IN (SELECT `UserId` 
                                                               FROM `UserInGroup` 
                                                               WHERE `GroupId` = :groupId)
                            ";
        }else{
            $queryString = "SELECT `UserId`,`Email`
                            FROM `User`
                            WHERE  (`Email` LIKE :info OR `UserId` LIKE :info) AND (`UserId` NOT IN (SELECT `UserId` 
                                                                                                     FROM `UserInGroup` 
                                                                                                     WHERE `GroupId` = :groupId))
                            ";
            
            $arraySearch[":info"] = '%'.$infoToSearch.'%';
        }

        $arraySearch[":groupId"] = $groupId;
        
        try{
            $getData = $this -> db -> Select($queryString, $arraySearch);
            foreach ($getData as $returnData){
                $data[] = array(
                    "id" => $returnData['UserId'],
                    "text" => $returnData['Email']
                );
            }               
        }catch (\Exception $e){
            $data[] = array(
                "id" => null,
                "text" => $e -> getMessage()
            );
        }

        $ajax['items'] = $data;
        return $ajax; 

    }

    function AddNewUserToGroup($param){
        try{
            $groupId = Cores\_Session::Get("CurrentUserInGroup");

            // Data to Store
            $data['UserId'] = $param['userId'];
            $data['GroupId'] = $groupId;
            $data['Description'] = "Add New User To Group";


            if ($data['UserId'] == 1){
                throw new \Exception ("This user is forbiden!");
            }

            return $this -> db -> Insert('UserInGroup', $data, "SELECT `UserId` FROM `UserInGroup` WHERE `GroupId` = :groupId AND `UserId` = :userId", 
                array(
                    ":groupId" => $groupId,
                    ":userId" => $data['UserId']
                )
            );
        }catch (\Exception $e){
            return $e -> getMessage();
        }
    }

    function RemoveUserFromGroup($param){
        try{
            $groupId = Cores\_Session::Get("CurrentUserInGroup");
            $userId = $param['userId'];

            $data = $this -> db -> Delete('DELETE FROM `UserInGroup` WHERE `GroupId` = :GroupId AND `UserId` = :UserId', array(':GroupId' => $groupId, ':UserId' => $userId));

            return $data;
        }catch (\Exception $e){
            return $e -> getMessage();
        }
    }
}
?>