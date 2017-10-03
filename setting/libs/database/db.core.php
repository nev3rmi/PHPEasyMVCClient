<?php
namespace PHPEasy\Cores;
class _Database extends \PDO{
	private $host = null;
	private $dbname = null;
	private $username = null;
	private $password = null;
	private $_dbInfo = null;

	function __construct($dbInfo = null){
		$this -> _dbInfo = $dbInfo;
		if (_Site::IsPDOAvailable()){
			$this -> InitDbConnection();
		}
	}

	/**
	 * GetDbConnectionInformation
	 * Get database from save key.
	 * @param string $fromKey key name.
	 * @return void
	 */
	public static function GetDbConnectionInformation($fromKey = 'dbConnectString'){
		$Security = new _Security;
		$Array = new _Array;
		$encryptedKey = $Security -> GetKey($fromKey);
		$privateKey = $Security -> GetKey('privateKey');
		$salt = $Security -> GetKey('salt');
		$decryptedKey = $Security -> DecryptData($encryptedKey, $privateKey, $salt);
		$getInfoFromKey = $Array -> Explode('|', $decryptedKey);
		return $getInfoFromKey;
	}

	/**
	 * InitDbConnection function
	 * Init Database connection, each time this function run, it will create the connection between apps and its db.
	 * @return void
	 */
	function InitDbConnection(){
		
		$dbInfo = $this -> _dbInfo;

		if ($dbInfo === null){
			$dbInfo = $this -> GetDbConnectionInformation();
		}
		
		// TODO: Need to recheck this part, if GetKey return Error then no more run
		if (!empty($dbInfo[3])){
			try{
				// Set PDO
				parent::__construct("mysql:host=$dbInfo[0];dbname=$dbInfo[3]", "$dbInfo[1]", "$dbInfo[2]");
				// Check number of connect to db if > 3 which mean code error.
				// $numberOfConnect = _Session::Get('CountDbConnect');
				// $numberOfConnect += 1;
				// _Session::Set('CountDbConnect', $numberOfConnect);
				// Set info
				$this -> host = $dbInfo[0];
				$this -> dbname = $dbInfo[3];
				$this -> username = $dbInfo[1];
				$this -> password = $dbInfo[2];
			}catch (\Exception $e){

			}
		}
		return $this;
	}
	
	/**
	 * Insert function
	 * This function will insert a new row in database.
	 * @param string $table Tablename
	 * @param array $data Array of data with the key is matched with column name. 
	 * @param array $keyToCheckExistinDB Array of data to match with $data
	 * @param array $signToCheck = > < LIKES in where query
	 * @param array $keyToRetreiveDataInDataArray Array of data to match with $keyToCheckExistinDB
	 * @param array $linkInBuild number of key start to check
	 * @return void
	 */
	function Insert($table, $data, $keyToCheckExistinDB = array(), $signToCheck = array(), $keyToRetreiveDataInDataArray = array(), $linkInBuild = array()){
		// 2 cai array se doi chieu voi nhau
		if ($keyToCheckExistinDB !== null){
			if (func_num_args() > 4){
				if (count($keyToCheckExistinDB) === count($keyToRetreiveDataInDataArray)){
					
					$queryString = 'SELECT * FROM `'.$table.'` WHERE ';
					$whereArray = null;
					$builtQueryString = null;
					for ($x = 0; $x < count($keyToCheckExistinDB); $x++){
						$thisBuiltQueryString = '`'.$keyToCheckExistinDB[$x].'`';
						$thisBuiltQueryString .= ' '.(!empty($signToCheck[$x])?$signToCheck[$x]:' = ');
						$thisBuiltQueryString .= ' :'.$keyToRetreiveDataInDataArray[$x];
						if ($x < count($keyToCheckExistinDB) - 1){
							$thisBuiltQueryString .= ' '.(!empty($linkInBuild[$x])?' '.$linkInBuild[$x].' ':' AND ');
						}
						$builtQueryString .= $thisBuiltQueryString;
						// Where Array
						$whereArray[':'.$keyToRetreiveDataInDataArray[$x]] = $data[$keyToRetreiveDataInDataArray[$x]];
					}

					$queryString .= $builtQueryString;
					$whereArray = array($whereArray);
					$checkingResult = $this -> Select($queryString, $whereArray[0]);
					if (count($checkingResult) > 0){
						return 'This record is already exist!';
					}
				}else{
					return 'Cannot Check Exist Because: 2 Params[keyToCheckExistinDB, keyToRetreiveDataInDataArray] doesn\'t match!';
				}
			}
			if (func_num_args() === 4){
				$checkingResult = $this -> Select($keyToCheckExistinDB, $signToCheck);
				if (count($checkingResult) > 0){
					return 'This record is already exist!';
				}
			}
		}
		ksort($data);
		$fieldNames = implode('`, `', array_keys($data));
		$fieldValues = ':'.implode(', :', array_keys($data));

		$queryString = "INSERT INTO `$table` (`$fieldNames`) VALUES ($fieldValues)";
		(new _Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Do Insert', "\nSQL String: $queryString \n Array: ".implode("\n",$data));
		
		$iQueryAble = $this -> prepare($queryString);
	
		foreach ($data as $key => $value){
			$iQueryAble->bindValue(":$key", $value);
		}

		if ($iQueryAble->execute()){
			return true;
		}

		throw new \Exception($iQueryAble->errorInfo());
	}

	/**
	 * Update function
	 * This function will update a row in database. 
	 * @param string $table Table name
	 * @param array $data Array of data with the key is matched with column name. 
	 * @param string $where SQL string after where
	 * @param array $array match with string $where
	 * @return void
	 */
	function Update($table, $data, $where, $array = array()){
		ksort($data);

		$fieldDetails = NULL;
		foreach($data as $key=> $value) {
            $fieldDetails .= "`$key`=:$key,";
        }
        $fieldDetails = rtrim($fieldDetails, ',');
        
		$query = "UPDATE `$table` SET $fieldDetails WHERE $where";
		(new _Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Do Update', "\nSQL String: $query \n Array: ".implode("\n",$array));
		
        $iQueryAble = $this->prepare($query);
        
        foreach ($data as $key => $value) {
            $iQueryAble->bindValue(":$key", $value);
        }

		if (func_num_args() === 4){
			foreach ($array as $key => $value) {
				$iQueryAble->bindValue("$key", $value);
			}	
		}
        if ($iQueryAble->execute()){
			return true;
		}

		throw new \Exception($iQueryAble->getMessage());
	}

   /**
	* Function Delete:
	* Delete rows in database. --->  
	* param1: string; SQLString 2 params or Table if 3 params --- 
	* param2: string, array; where array in 2 params or where string if 3 params ---  
	* param3: int; Limit if 3 params.
	* @param string $param1 Type: string -> SQLString 2 params or Table if 3 params
	* @param mixed $param2 Type: string, array -> Where array in 2 params or where string if 3 params
	* @param int $param3 Type: int -> Limit
	*/
	function Delete($param1, $param2 = null, $param3 = 1){
		(new _Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Do Delete', "\nSQL String: $param1 \n Array: ".implode("\n",$param2));
		switch (func_num_args()){
			case 2:
					// Make sure null = default
					if ($param2 == null){
						$param2 = array();
					}
					$iQueryAble = $this->prepare($param1);
					foreach ($param2 as $key => $value) {
						$iQueryAble->bindValue("$key", $value);
					}
					if ($iQueryAble->execute()){
						return true;
					}
					throw new \Exception($iQueryAble->getMessage());
					break;
			case 3:
					if ($param3 === null){
						$param3 = 1;
					}
					
					if ($this->exec("DELETE FROM `$param1` WHERE $param2 LIMIT $param3")){
						return true;
					}
					throw new \Exception($iQueryAble->getMessage());
					break;
		}	
	}

	/**
	 * Select function
	 * Select command in pdo.
	 * @param string $sqlString SQL select string
	 * @param array $array match with pdo var
	 * @param boolean $fetchAll fetch row or a single line
	 * @param pdoFetch $fetchMode
	 * @return void
	 */
	function Select($sqlString, $array = array(), $fetchAll = true, $fetchMode = \PDO::FETCH_ASSOC){
		(new _Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Do Select', "\nSQL String: $sqlString \n Array: ".implode("\n",$array));
		// Make sure null = default
		if ($array === null){
			$array = array();
		}
		if ($fetchAll === null){
			$fetchAll = true;
		}
		if ($fetchMode === null){
			$fetchMode = \PDO::FETCH_ASSOC;
		}
		// Main function
		$iQueryAble = $this->prepare($sqlString);
        foreach ($array as $key => $value) {
            if (!$iQueryAble->bindValue("$key", $value)){
				(new _Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Bidding Failed', "Key: $key, Value: $value");
			}
        }
        
        if ($iQueryAble->execute()){
			if ($iQueryAble -> rowCount() === 0){
				return array();
			}
			if ($fetchAll == true){
				return $iQueryAble->fetchAll($fetchMode);
			}
			return $iQueryAble->fetch($fetchMode);
		}else{
			throw new \Exception($iQueryAble -> getMessage());
			(new _Log(__NAMESPACE__, __CLASS__, __FUNCTION__)) -> WriteLog('Database Get Error', $iQueryAble -> getMessage());
		}
	}

	/**
	 * ShowAllTablesName function
	 *
	 * @param string $fromDb Database name
	 * @return void
	 */	
	function ShowAllTablesName($fromDb = null){
		if ($fromDb === null){
			$fromDb = "SELECT DATABASE()";
		}
		$result = $this -> Select("SELECT TABLE_NAME FROM information_schema.tables WHERE table_schema = (".$fromDb.") and TABLE_TYPE = 'BASE TABLE'");
		return $result;
	}

	/**
	 * CheckColumnExist function
	 * Check if column exist in the table or not.
	 * @param string $tableName table name 
	 * @param string $columnName column name
	 * @param string $fromDb database name
	 * @return void
	 */
	function CheckColumnExist($tableName, $columnName = null, $fromDb = null){
		if ($fromDb === null){
			$fromDb = "SELECT DATABASE()";
		}

		if ($columnName === null){
			$columnName = "ObjectId";
		}

		$query = "SELECT * 
					FROM information_schema.COLUMNS 
					WHERE 
						TABLE_SCHEMA = (SELECT DATABASE()) 
					AND TABLE_NAME = '$tableName' 
					AND COLUMN_NAME = '$columnName'";

		$result = $this -> Select($query);
		if (count($result) > 0){
			return true;
		}
		return false;
	}

	/**
	 * IsDbConnected function
	 * Check the db connect successful or not.
	 * @return void
	 */	
	public function IsDbConnected(){
		if ($this -> getAttribute(\PDO::ATTR_CONNECTION_STATUS)){
			return true;
		}
		return false;
	}

	//==================================================
	//             ACL Function
	// =================================================

	public function CreateObjectAcl($tableName, $primaryKey, $ownedBy){
		$data = array(
			'TableName' => $tableName,
			'PrimaryKey' => $primaryKey,
			'OwnedBy' => $ownedBy
		);
		return $this -> Insert('Object', $data);
	}

	public function DeleteObjectAcl($tableName, $primaryKey){
		return $this -> Delete('DELETE FROM `Object` WHERE `TableName` = :tableName AND `PrimaryKey` = :primaryKey', array(
			':tableName' => $tableName,
			':primaryKey' => $primaryKey
		));
	}

	public function GetObjectAcl($tableName, $primaryKey){
		$result = $this -> Select('SELECT `ObjectId` FROM `Object` WHERE `TableName` = :tableName AND `PrimaryKey` = :primaryKey', array(
			':tableName' => $tableName,
			':primaryKey' => $primaryKey
		), false);
		return $result['ObjectId'];
	}
	
	//==================================================
	//             Quick Access Function
	// =================================================

	/**
	 * IsPDOAvailable function
	 * Check if PDO exist in this server or not.
	 * @return void
	 */
	public static function IsPDOAvailable(){
		return _Site::IsPDOAvailable();
	}
}

	// function GenerateDbInfo($hostname, $username, $password, $dbName, $passwordFile = '_password', $privateKeyFile = '_privateKey'){
	// 	$getPrivateKey = _Security::GetKey($privateKeyFile);
	// 	$getPassword = _Security::GetKey($passwordFile);
	// 	$data = $hostname.'|'.$username.'|'.$password.'|'.$dbName.'|++';
	// 	$encryptKey = _Security::EncryptData($data, $getPrivateKey, $getPassword);
	// 	return $encryptKey;
	// }
	// // TODO: Implement Dynamic Insert
	// function Insert($table, $data){
	// 	ksort($data);
	
	// 	$fieldNames = implode('`, `', array_keys($data));
	// 	$fieldNames = str_replace(':', '',$fieldNames);
	// 	$fieldValues = implode(', ', array_keys($data));

	// 	$query = "INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)";

	// 	$iQueryAble = $this -> prepare($query);

	// 	foreach ($data as $key => $value){
	// 		$iQueryAble->bindValue("$key", $value);
	// 	}

	// 	$iQueryAble -> execute();
	// }

	// // TODO: Implement Dynamic Update // Should be an other array to put where value in
	// function Update($table, $data, $where){
	// 	ksort($data);

	// 	$fieldDetails = NULL;
	// 	foreach($data as $key=> $value) {
    //         $fieldDetails .= '`'.substr($key,1).'`= '.$key.',';
    //     }
    //     $fieldDetails = rtrim($fieldDetails, ',');
        
	// 	$query = "UPDATE $table SET $fieldDetails WHERE $where";

    //     $iQueryAble = $this->prepare($query);
        
    //     foreach ($data as $key => $value) {
    //         $iQueryAble->bindValue("$key", $value);
    //     }
        
    //     $iQueryAble->execute();
	// }

	// DELETE FROM `User` WHERE `UserId` = :id LIMIT 1

	// function BackupDb(){
	// 	define("BACKUP_PATH", "/home/abdul/");
	// 	$server_name   = "localhost";
	// 	$username      = "root";
	// 	$password      = "root";
	// 	$database_name = "world_copy";
	// 	$date_string   = date("Ymd");
	// 	$cmd = "mysqldump --routines -h {$server_name} -u {$username} -p{$password} {$database_name} > " . BACKUP_PATH . "{$date_string}_{$database_name}.sql";
	// 	exec($cmd);
	// }
	// function RestoreDb($dbFile){
	// 	$restore_file  = "/home/abdul/20140306_world_copy.sql";
	// 	$server_name   = "localhost";
	// 	$username      = "root";
	// 	$password      = "root";
	// 	$database_name = "test_world_copy";
	// 	$cmd = "mysql -h {$server_name} -u {$username} -p{$password} {$database_name} < $restore_file";
	// 	exec($cmd);
	// }

	// // TODO: Make it work

	// /*
	// SELECT * FROM `Group` WHERE `GroupId` = 1
	// */
	// // function CreateStoreProcedure($procName, $iQueryAble, $array = array(), $param = null, $update = true){
	// // 	$query = "CREATE PROCEDURE `$procName`( In id varchar(255))
	// // 				BEGIN
	// // 				".$iQueryAble."
	// // 				END";

	// // 	return ;
	// // }

	// function CreateStoreProcedure($procName, $SQLQuery, $param = null, $username = null, $hostname = null, $update = true){
	// 	if ($username === null){
	// 		$username = $this->username;
	// 	}
	// 	if ($hostname === null){
	// 		$hostname = $this->host;
	// 	}
	// 	if ($update){
	// 		$this->exec("DROP PROCEDURE IF EXISTS `$procName`");
	// 	}
	// 	$iQueryAble = "CREATE ALGORITHM=UNDEFINED DEFINER=`$username`@`$hostname` SQL SECURITY DEFINER PROCEDURE `$procName`( $param)
	// 					BEGIN
	// 					$SQLQuery
	// 					END;";
	// 	echo $iQueryAble;
	// 	die;	
	// 	return $this -> exec($iQueryAble);

	// }
