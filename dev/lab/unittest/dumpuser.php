<?php require_once($_SERVER['DOCUMENT_ROOT']."/setting/core.php"); ?>
<?php
$hashPassword = $_Security -> HashKey('SkYLiGhT');
$encryptPassword = $_Security -> HashEncryptedWithSalt($hashPassword);

$privateKey = $_Security -> CreateSalt();

$test = $_Security -> ValidateHashKeyAndHashEncrypted($hashPassword, '4b52555772356b5272686a54333130645a316d52725a454d4652545733557a51614e6c557a3545627270585a4739574e53526c52594e6d616b4e7a55574a46624e4a6a5643525656336c5859743545564f56306136464757465658557570565954706e514e466c626164465a475a554e505a455a34395552316b315459706c6556706d527945325678635557554a305356686b55794a465261645659455a31555a42544f53356b6547743059705654524e526b5277564757434e46546e315450');

$_Ultility -> ConsoleData((int)($test));
$_Ultility -> ConsoleData($privateKey);
?>