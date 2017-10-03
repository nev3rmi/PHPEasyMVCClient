<?php
namespace PHPEasy\Cores;
class _CUrl{
    private $params = null;
    private $toString = null;
    private $url = null;
    private $error = array();

    private $_curl = null;

    private $returnObj = null;

    function Send($url, $params, $method = "POST"){
        $this -> SetUrl($url);

        if ($method == "POST"){
            $this -> SetVariable($params);
            $this -> InitPost();
        }else{
            $this -> InitGet();
        }
        
        $this -> Execute();

        return $this -> Fetch();
    }

    private function InitGet(){
        try{
            $this -> _curl = curl_init( $this -> url );
            curl_setopt($this -> _curl, CURLOPT_RETURNTRANSFER, 1);
        }catch (\Exception $e){
            $this -> error[] = $e -> GetMessage();
        }
    }

    private function InitPost(){
        try{
            $this -> _curl = curl_init( $this -> url );
            curl_setopt( $this -> _curl, CURLOPT_POST, 1);
            curl_setopt( $this -> _curl, CURLOPT_POSTFIELDS, $this -> toString);
            curl_setopt( $this -> _curl, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt( $this -> _curl, CURLOPT_HEADER, 0);
            curl_setopt( $this -> _curl, CURLOPT_RETURNTRANSFER, 1);
        }catch (\Exception $e){
            $this -> error[] = $e -> GetMessage();
        }
    }

    function SetUrl($url){
        if (preg_match(_Setting::_regexFullUrl, $url)){
            $this -> url = $url;
        }else{
            $this -> error[] = "URL is invalid!";
        }

        return $this;
    }

    function SetVariable($params){
        $this -> params = $params;
        $this -> toString = http_build_query($this -> params);

        return $this;
    }

    function Execute(){
        if (empty($this -> error)){
            $this -> returnObj = curl_exec( $this -> _curl );
        }else{
            echo implode("\n", $this -> ShowError());
        }
    }

    function Exec(){
        $this -> Execute();
    }

    function ShowError(){
        return $this -> error;
    }

    function Fetch(){
        return $this -> returnObj;
    }
}
?>