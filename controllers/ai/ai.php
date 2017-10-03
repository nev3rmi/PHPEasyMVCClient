<?php
namespace PHPEasy\Controllers;
use PHPEasy\Cores as Cores;

class AI extends Cores\_Controller{
    function Index(){
        $a = $this -> model -> KNearestNeighbors();
        $this -> view -> content($a);
    }

    function GetClass(){
        print_r(Cores\_Site::GetClass());
    }

    function wineQuality(){
        $a = $this -> model -> wineQuality();
        $this -> view -> content($a);
    }

    function MLPClassifier(){
        $a = $this -> model -> MLPClassifier();
        $this -> view -> content($a);
    }
}

?>