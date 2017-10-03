<?php
namespace PHPEasy\Cores;
class _Sitemap{
    public $sitemapData = null;
    public $sitemapMatchingData = null;

    public function __construct(){
        $this -> db = new _Database;
        $this -> Init();
        $this -> sitemapData = $this -> GenerateSiteMap($this -> user -> id);
        $this -> MatchingIdWithURL();
        $this -> SetData();
        unset($this -> db);
    }

    private function Init(){
        $this -> user = _Session::Get('loggedUser');
    }

    private function SetData(){
        // Clean Data
        unset($this -> user);
        // Save Data
        _Session::Set('sitemap', $this);
    }

    public function GenerateSiteMap($userId){ // TODO: need to put date and time created it, calculate change, priority.
		$queryString = "SELECT `a`.`FunctionId`, `a`.`FunctionName`, `a`.`PageUrl`, `a`.`UpdatedTime` FROM `Function` a
						JOIN `Object` b ON `a`.`FunctionId` = `b`.`PrimaryKey` AND `b`.`TableName` = 'Function'
						JOIN `ACL` c ON `b`.`ObjectId` = `c`.`ObjectId` AND `c`.`Value` = 1
						JOIN `UserInGroup` d ON `c`.`GroupId` = `d`.`GroupId`
						WHERE `d`.`UserId` = :userId
                        GROUP BY `a`.`FunctionId`";
        $content = $this -> db -> Select($queryString, array(":userId" => $userId));
        return $content;
    }

    private function MatchingIdWithURL(){
        foreach ($this -> sitemapData as $key => $value){
            $this -> sitemapMatchingData[$value['FunctionId']] = $value['PageUrl'];
        }
    }
}
?>