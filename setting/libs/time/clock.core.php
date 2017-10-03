<?php
namespace PHPEasy\Cores;
class _Clock extends \DateTime{
    public $clockTimeZone = null;
    public $clockDate = null;
    public $clockTime = null;
    public $clockDateTime = null;
    
    function __construct($inputDate = null, $inputTime = null, $inputTimeZone = null){
        $this -> Set($inputDate, $inputTime, $inputTimeZone);
        parent::__construct($this -> clockDateTime, new \DateTimeZone($this -> clockTimeZone));
        $this -> FinalSet();
    }

    private function Set($inputDate, $inputTime, $inputTimeZone){
        if ($timeZone !== null){
            $this -> clockTimeZone = $inputTimeZone;
        }else{
            $this -> clockTimeZone = _Setting::_defaultTimeZone;
        }
        if ($time !== null){
            $this -> clockTime = $inputTime;
        }else{
            $this -> clockTime = _Setting::_defaultTime;
        }
        $this -> clockDate = $inputDate;
        if ($this -> clockDate !== null){
            $this -> clockDateTime = $this -> clockDate.' '.$this -> clockTime;
        }else{
            $this -> clockDateTime = _Setting::_defaultDate;
        }
    }

    private function FinalSet(){
        $dateTime = (new \ReflectionObject($this)) -> getProperty('date') -> getValue($this);
        $dateTimeExpl = explode(' ', $dateTime);
        $this -> clockDateTime = $dateTime;
        $this -> clockDate = $dateTimeExpl[0];
        $this -> clockTime = $dateTimeExpl[1];
    }
}
?>