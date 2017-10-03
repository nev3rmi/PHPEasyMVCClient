<?php
namespace PHPEasy\Cores;
abstract class _Bit{
    private $value;

    public function __construct($value=0) {
        $this->value = $value;
    }

    // Return valud of 2^n
    public function GetValue() {
        return $this->value;
    }
    
    // Check if allow to do
    public function Get($n) {
        return ($this->value & $n) == $n;
    }

    // Pre set permission
    public function Set($n) {
        $this->value |= $n;
    }

    // Clear set permission
    public function Clear($n) {
        $this->value &= ~$n;
    }
}
?>