<?php
namespace PHPEasy\Models\Api;
use PHPEasy\Cores as Cores;
use PHPEasy\Models as Models;

class Version extends Models\Api{
	private $_system = null;
	private $_listOfVersionPackage = null;
	
	function CheckUpdate(){
		$result = false;
		$system = $this -> GetSystemInfo();
		$versionList = $this -> GetServerVers();
		if ($versionList != null)
		{
			if ($system['version'] != end($versionList)){
				$result = true;
			}
		}
		return $result;
	}

	function GetServerVers(){
		$result = null;
		$system = $this -> GetSystemInfo();
		$getVersions = file_get_contents($system['serverLink']) or die ('ERROR');
		if ($getVersions != '')
		{
			$getVersions = trim($getVersions);
			$versionList = explode("\n", $getVersions);
			$result = array_filter($versionList);
		}
		return $result;
	}

	function GetSystemInfo(){
		$system = Cores\_Session::Get('system') -> Get();
		return $system;
	}

	function GetListUpdate(){
		$serverVersion = $this -> GetServerVers();
		$currentVersion = $this -> GetSystemInfo()['version'];

		$record = false;
		$getArray = array();
		foreach ($serverVersion as $version){
			$version = trim($version);
			if ($record == true){
				$getArray[] = $version;
			}
			if ($version == $currentVersion){
				$record = true;
			}
		}
		return $getArray;
	}

	function DoUpdate($download = true, $install = true){
		$this -> _system = $this -> GetSystemInfo();
		$this -> _listOfVersionPackage = $this -> GetListUpdate();
		if (count($this -> _listOfVersionPackage) > 0){
			foreach($this -> _listOfVersionPackage as $package){
				// Download Package
				if ($download){
					$this -> DownloadPackage($package);
				}
				// Install Package
				if ($install){
					$this -> InstallPackage($package);
				}
				// Update version
				$this -> SetSystemInfo($package);
			} 
			echo '<p>Update Finish .......</p>';
			echo '<a href="/api/version/checkupdate">Go Back</a>';
		}else{
			header('Location: /api/version/checkupdate');
		}
	}

	// TODO: 
	private function DownloadPackage($package){
		$downloadedFileDir = Cores\_Site::GetRoot().'setting/api/phpeasy/package/';
		$downloadedFile = $downloadedFileDir.'phpeasy-v'.$package.'.zip';
		$downloadFileFrom = $this -> _system['packageLink'].'/v'.$package.'.zip';
		//Download The File If We Do Not Have It
		if ( !is_file($downloadFile)) { // Check if file exist
			echo '<p>Downloading New Update</p>';
			// Create Dir if not exist
			if ( !is_dir( $downloadedFileDir ))
			{
				echo '<p>Creating Dir: '.$downloadedFileDir.'</p>';
				mkdir ( $downloadedFileDir );
			} 
				
			echo '<p>Download From: <a href="'.$downloadFileFrom.'" target="_blank">'.$downloadFileFrom.'</a>';
			$newUpdate = file_get_contents($downloadFileFrom);
			$dlHandler = fopen($downloadedFile, 'w');
			if ( !fwrite($dlHandler, $newUpdate) ) { 
				echo '<p>Could not save new update. Operation aborted.</p>'; 
				exit(); 
			}
			fclose($dlHandler);
			echo '<p>Update Downloaded And Saved</p>';
		} else {
			echo '<p>Update already downloaded, begin to install!</p>';	
		}
	}

	// $package -> version
	private function InstallPackage($package){
		$downloadedFileDir = Cores\_Site::GetRoot().'setting/api/phpeasy/package/';
		$downloadedFile = $downloadedFileDir.'phpeasy-v'.$package.'.zip';
		$downloadFileFrom = $this -> _system['packageLink'].'/v'.$package.'.zip';

		$zipHandle = zip_open($downloadedFile);
		echo '<ul>';
		while ($aF = zip_read($zipHandle) ) 
		{
			$thisFileName = zip_entry_name($aF);
			$thisFileDir = dirname($thisFileName);
			$thisFileExtension = pathinfo($thisFileName, PATHINFO_EXTENSION);
			
			//Continue if its not a file
			if ( substr($thisFileName,-1,1) == '/') continue;
			

			//Make the directory if we need to...
			if ( !is_dir ( Cores\_Site::GetRoot().$thisFileDir ) )
			{
				mkdir ( Cores\_Site::GetRoot().$thisFileDir );
				echo '<li>Created Directory '.$thisFileDir.'</li>';
			}

			if ( !is_dir(Cores\_Site::GetRoot().$thisFileName) ) {
				echo '<li>'.$thisFileDir.'/'.$thisFileName.'...........';
				$contents = zip_entry_read($aF, zip_entry_filesize($aF));
				$contents = str_replace("\r\n", "\n", $contents);
				if ($thisFileExtension == "sql"){
					echo 'Executed SQL File: '.$thisFileDir.'...........';
					echo ($this -> db -> exec($content) == 0)?'Success':'Failed';
				}else{
					$updateThis = '';
					$updateThis = fopen(Cores\_Site::GetRoot().$thisFileName, 'w');
					fwrite($updateThis, $contents);
					fclose($updateThis);
					unset($contents);
					echo' UPDATED';
				}
				echo '</li>';
			}
		}
		echo '</ul>';
		// Delete File
		$this -> DeleteFile($package);
	}

	private function SetSystemInfo($version){
		$system = $this -> GetSystemInfo();
		$system['version'] = $version;
		Cores\_Session::Get('system') -> Save($system);
	}

	private function DeleteFile($package){
		$downloadedFileDir = Cores\_Site::GetRoot().'setting/api/phpeasy/package/';
		$downloadedFile = $downloadedFileDir.'phpeasy-v'.$package.'.zip';
		echo '<p>Delete Downloaded File</p>';
		unlink($downloadedFile);
	}
}
?>