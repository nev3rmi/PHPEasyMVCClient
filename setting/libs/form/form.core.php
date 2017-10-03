<?php
namespace PHPEasy\Cores;
class _Form {

    private $_currentItem = null;
    private $_postData = array();
    private $_val = array();
    private $_error = array();


    public function __construct(){
         $this->_val = new _Validation();
    }

    public function Post($field){
        $this -> _postData[$field] = $_POST[$field];
        $this->_currentItem = $field;
        return $this;
    }

    public function Get($field){
        $this -> _postData[$field] = $_GET[$field];
        $this->_currentItem = $field;
        return $this;
    }

    public function Input($field, $value){
        $this -> _postData[$field] = $value;
        $this->_currentItem = $field;
        return $this;
    }

    public function Fetch($fieldName = false)
    {
        if ($fieldName) 
        {
            if (isset($this->_postData[$fieldName])){
                return $this->_postData[$fieldName];
            }else{
                return false;
            }
        } 
        else 
        {
            return $this->_postData;
        }
        
    }

    // Function will be regex and it will be build in _Setting::RegexName
    public function Validate($typeOfValidator, $arg = null){
        if ($arg == null){
            $error = $this->_val->{$typeOfValidator}($this->_postData[$this->_currentItem]);
        }else{
            $error = $this->_val->{$typeOfValidator}($this->_postData[$this->_currentItem], $arg);
        }
        if ($error){
            $this->_error[$this->_currentItem] = $error;
        }
        return $this;
    }

    public function Submit()
    {
        if (empty($this->_error)) 
        {
            return true;
        } 
        else 
        {   
            $this -> GetError();
            return false;
        }
    }

    public function GetError(){
        if (!empty($this -> _error)){
            $str = '';
            foreach ($this->_error as $key => $value)
            {
                $str .= $key . ' => ' . $value . "\n";
            }
            throw new \Exception($str);
        }
    }

}
?>