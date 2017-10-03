<?php
namespace PHPEasy\Models\Admin;
use PHPEasy\Cores as Cores;
use PHPEasy\Models as Models;

class User extends Models\Admin{
    public function GetUser(){
        $queryString = "SELECT `UserId`, `FacebookOauthId`, `GoogleOauthId`, `Email`, `FirstName`, `LastName`, `Gender`, `DOB`, `AvatarUrl` FROM `User`";
        $datas = $this -> db -> Select($queryString);
        foreach ($datas as $returnData){
            foreach($returnData as $key => $value){
                $row[$key] = $value;
            }
            $row["Action"] = ($returnData['UserId'] !== null) ? $viewGroupColumn.$editActionColummn.$deleteActionColumn : null;
            $row["PageRowId"] = "row_user_".$returnData['UserId'];
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
}
?>