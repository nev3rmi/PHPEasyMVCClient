<?php
namespace PHPEasy\Controllers\Login\Route\Oauth;
use PHPEasy\Cores as Cores;
use PHPEasy\Controllers as Controllers;

class Google extends Controllers\Login\Route\Oauth{
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
                $form -> Input('GoogleOauthId', $_POST['id']);
                $form -> Input('IsActive', 1);
            }

            CheckEmail:
            if (!empty($_POST['emails'][0]['value'])){
                $form -> Input('Email', $_POST['emails'][0]['value']);
            }else{
                if (empty($_POST['id'])){
                    goto Invalid;
                }
            }

            // Optional
            OptionalCheck:
            if (!empty($_POST['image']['url'])){
                $form -> Input('AvatarUrl', $_POST['image']['url']);
            }
            if (!empty($_POST['birthday'])){
                $form -> Input('DOB', $_POST['birthday']);
            }
            if (!empty($_POST['name']['givenName'])){
            $form -> Input('FirstName', $_POST['name']['givenName']);
            }
            if (!empty($_POST['name']['familyName'])){
            $form -> Input('LastName', $_POST['name']['familyName']);
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

