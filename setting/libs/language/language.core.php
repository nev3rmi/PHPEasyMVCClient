<?php
namespace PHPEasy\Cores;
class _Language{
    public $allSiteLanguage = null;
    public $id = null;
    public $name = null;
    public $description = null;
    public $symbol = null;
    public $imageCode = null;

    public function __construct($id = 1){
        // Connect to DB
        $this -> db = new _Database;
        // Init
        $this -> Init($id);
        // Get Language
        $this -> GetSiteLanguage();
        // Close DB Connection
        unset($this -> db);
    }

    private function Init($id){
        $query = "SELECT `LanguageName`, `Description`, `Symbol`, `ImageCode` FROM `Language` WHERE `LanguageId` = :languageId";
        $data = $this -> db -> Select($query, array(":languageId" => $id), false);

        if (count($data) > 0){
            $this -> id = $id;
            $this -> name = $data['LanguageName'];
            $this -> description = $data['Description'];
            $this -> symbol = $data['Symbol'];
            $this -> imageCode = $data['ImageCode'];
        }

        return $this;
    }

    private function GetSiteLanguage(){
        $query = "SELECT * FROM `Language`";
        $data = $this -> db -> Select($query);

        if (count($data) > 0){
            $this -> allSiteLanguage = $data;
        }

        return $this;
    }
}
?>