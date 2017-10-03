<?php
namespace PHPEasy\Controllers\Login\Route\Oauth;
use PHPEasy\Cores as Cores;
use PHPEasy\Controllers as Controllers;

class Facebook extends Controllers\Login\Route\Oauth{
    function __construct(){
        parent::__construct();
    }

    // TODO: Bug HERE
    function Index($param){ // Work // -> Just check: All Index need to have $param
        $this -> view -> content("Please wait...");
    }

    function Authenticate(){
        try
        {
            $form = new Cores\_Form;
            // Primary
            CheckId:
            if (!empty($_POST['id'])){
                $form -> Input('FacebookOauthId', $_POST['id']);
                $form -> Input('AvatarUrl', "http://graph.facebook.com/" .$_POST['id']. "/picture");
                $form -> Input('IsActive', 1);
            }

            CheckEmail:
            if (!empty($_POST['email'])){
                $form -> Input('Email', $_POST['email']);
            }else{
                if (empty($_POST['id'])){
                    goto Invalid;
                }
            }

            // Optional
            OptionalCheck:
            if (!empty($_POST['birthday'])){
                $explodeDob = explode("/", $_POST['birthday']);
                $dob = $explodeDob[2]."-".$explodeDob[1]."-".$explodeDob[0]; 
                $form -> Input('DOB', $dob);
            }
            if (!empty($_POST['first_name'])){
            $form -> Input('FirstName', $_POST['first_name']);
            }
            if (!empty($_POST['last_name'])){
            $form -> Input('LastName', $_POST['last_name']);
            }
            if (!empty($_POST['gender'])){
            $form -> Input('Gender', $_POST['gender'] == "male" ? 1 : 0);
            }

            Fetch:
            $form -> Submit();
            $data =  $form -> Fetch();

            Process:
            $result = $this -> model -> ProcessSignIn($data);
            echo $result;
            return;

            Invalid:
            $result = "You need to turn on either email or allow us to get your facebook ID";
            echo $result;
            return;

        }catch (Exception $e){

        }
        
    }
}

