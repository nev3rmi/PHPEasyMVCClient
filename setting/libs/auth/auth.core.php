<?php
namespace PHPEasy\Cores;
class _Auth{
    function __construct($page = null, $session = true){
        $this -> SetPermission($page, $session);
        $this -> CheckAllowToAccess();
        $this -> CheckPassword();
    }
    
    private function SetPermission($page, $session){
        // this page in array of loggedemployee permission
        _Session::Init();
        if ($page == null){
            $page = _Session::Get('page');
        }
        $key = $page -> pageId;
        $user = _Session::Get('loggedUser');
        $userId = $user -> userId;
        $userPermission = $user -> permission;
        
        // Page Permission
        if (array_key_exists($key, $userPermission)){
            $value = $userPermission[$key];
        }else{
            $value = 0;
        }

        $page -> permission -> Set($value);
        // Set Session
        if ($session){
            _Session::Set('page', $page);
        }
    }
    private function CheckAllowToAccess(){
        $page = _Session::Get('page');
        if ($page -> permission -> Get(_Permission::Read) == false){
            // TODO: if don't have permission then kick out
            // echo "You don't have permission to access this page";
            if (_Setting::_switchSecurity || _Setting::_switchSecurity === 1){
                header("Location: "._Site::GetUrl()."error/error403");
                exit;
            }
        }
    }

    private function CheckPassword(){
        $page = _Session::Get('page');
        $tryToGetPassword = _Session::Get('page-auth');
        if (!empty($page -> pagePassword)){
            if (!empty($tryToGetPassword) && $page -> pageUrl == $tryToGetPassword['pageUrl']){
                // print_r($tryToGetPassword);
            //     // if ($tryToGetPassword['attempt'] < 2){
            //         // Do Check pass
            //         if ($GLOBALS['_Security'] -> ValidateHashKeyAndHashEncrypted($page -> pagePassword, $tryToGetPassword -> typeInPassword)){
            //             return;
            //         }else{
            //             // $store['attempt'] = $tryToGetPassword['attempt']++;
            //             goto Redo;
            //         }
            //     // }else{
            //     //     header("Location: "._Site::GetUrl()."error/error401");
            //     //     exit;
            //     // }

                if ($GLOBALS['_Security'] -> ValidateHashKeyAndHashEncrypted($tryToGetPassword['typeInPassword'], $page -> pagePassword)){
                    return;
                }
                goto Redo;
            }else{
                Redo:
                // TODO: Should put locker array here, if pass already pass in, no more needed to re type password.
                // Create session
                $store['pageUrl'] = $page -> pageUrl;
                $store['typeInPassword'] = null;

                _Session::Set('page-auth', $store);
                // Redirect to page auth
                header("Location: "._Site::GetUrl()."auth/validatepage");
                exit;
            }
        }
        return;
    }
}
?>