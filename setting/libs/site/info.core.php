<?php
namespace PHPEasy\Cores;
class _System{
    private $storage = array();

    public function __construct($session = true){
        if ($this -> storage == null){
            $this -> _getSiteInfoFromStorage($session);
        }
        if ($session){
            $this -> _sessionSiteInfo();
        }
    }

    private function _getSiteInfoFromStorage($session){
		$getPrivateKey = _Security::GetKey('privateKey');
		$getSalt = _Security::GetKey('salt');
		$siteInfo = _Security::GetKey('system');
		$siteInfo = _Security::DecryptData($siteInfo,$getPrivateKey, $getSalt);
		$siteInfo = json_decode($siteInfo, true);
		$this -> Set($siteInfo, $session);
	}

    function Set($system, $session){
        $this -> storage['version'] = $system['version'];
        $this -> storage['serverLink'] = $system['serverLink'];
        $this -> storage['packageLink'] = $system['serverPackageLink'];
        
        if ($session){
            $this -> _sessionSiteInfo();
        }
        
        return $this;
    }

    function Get($key = null){
        if ($key == null){
            return $this -> storage;
        }else{
            return $this -> storage[$key];
        }
    }

    private function _sessionSiteInfo(){
        _Session::Init();
        _Session::Set('system', $this);
    }

    function Save($system, $session){
        $this -> Set($system, $session);
        $siteInfo = json_encode($system);
        $siteInfo = _Security::EncryptData ($siteInfo, _Security::GetKey('privateKey'), _Security::GetKey('salt'));
        _Security::SaveKey('system', $siteInfo);
        echo "<p>Successful update to version: ". $system['version'].'</p>';
    }
}
?>