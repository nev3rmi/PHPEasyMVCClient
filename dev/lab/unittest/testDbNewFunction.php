<?php 
namespace  PHPEasy\Cores;
require_once($_SERVER['DOCUMENT_ROOT']."/setting/core.php");

// echo "Test :testId, false <br>";

$db = new _Database(_Database::GetDbConnectionInformation('dbConnectString'));

// Insert Work
// $prepareInsert = array(
//     'TestName' => 'TestMe1',
//     'TestValue' => '1',
//     'TestDesc' => 'asdasdasdasda'
// );
// $db -> Insert('Test', $prepareInsert);


// Select Work
// Work
// $result = $db -> Select('SELECT * FROM Test');
// print_r($result); 

// Work
// $result = $db -> Select('SELECT * FROM `Test` WHERE `TestId` = :TestId', array(':TestId' => 1));
// print_r($result); 

// Work
// $result1 = $db -> Select('SELECT * FROM `Test`', null , false);
// echo $result1['TestId'];
// echo '<br>'; 
// $result = $db -> Select('SELECT * FROM `Test`');
// echo $result[0]['TestId'];


// Update Work
// Work
// $db -> Update('Test', array('TestName' => 'TestMeToo1187'), '`TestId` = 6');
// Over load update
//echo $db -> Update('Test', array('TestName' => 'TestMeToo'), '`TestId` = :TestId', array(':TestId' => '6'));

// Delete
// echo $db -> Delete('Test', '`TestId` = 5', 1);
// echo $db -> Delete('DELETE FROM `Test` WHERE `TestId` = :TestId', array(':TestId' => 3));

// $db -> IsDbConnected();

echo _Session::Get('CountDbConnect');

?>