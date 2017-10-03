<?php
namespace PHPEasy\Cores;
class _Array{
	private $_array = null;

	public function __construct($array = null){
		$this -> _array = $array;
	}

	public function PriorKey($array, $value){
		$key = array_search($value, $array);
		if($key){
			unset($array[$key]);
			array_unshift($array, $value);  
		} 
		return $array;
	}

	public function LowPriorKey($array, $value){
		$key = array_search($value, $array);
		if($key){
			unset($array[$key]);
			array_push($array, $value);  
		} 
		return $array;
	}

	public function Explode($symbol, $string){
		$explode = explode($symbol,$string);
		return $explode;
	}

	public function PriorKeyArrangeByArray($array, $arrangeArray){
		$arrangeArray = array_reverse($arrangeArray);
		foreach ($arrangeArray as $value){
			$array = $this -> PriorKey($array, $value);
		}
		return $array;
	}

	public function LowPriorKeyArrangeByArray($array, $arrangeArray){
		$arrangeArray = array_reverse($arrangeArray);
		foreach ($arrangeArray as $value){
			$array = $this -> LowPriorKey($array, $value);
		}
		return $array;
	}

	public function GetArray($index = false) {
        return $index !== false ? $this -> _array[$index] : $this -> _array;
    }

	function FlattenArray() {
		$return = array();
		array_walk_recursive($this -> _array, function($a) use (&$return) { $return[] = $a; });
		return $return;
	}

}
