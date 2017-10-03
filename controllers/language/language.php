<?php
namespace PHPEasy\Controllers;
use PHPEasy\Cores as Cores;

class Language extends Cores\_Controller{
    function __construct(){
		parent::__construct();
	}

    function InitLanguage(){
        try{
            $form = new Cores\_Form;
            $form -> Post('lang')
                    -> Validate('Digit')
                -> Submit();
            $data = $form -> Fetch();
            Cores\_Session::Set('Language', new Cores\_Language($data['lang']));
            echo true;
        }catch (\Exception $e){
            echo $e -> GetMessage();
        }
    }
}

?>