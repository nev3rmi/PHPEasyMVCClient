<?php require_once($_SERVER['DOCUMENT_ROOT']."/setting/core.php"); ?>
<?php
use PHPEasy\Cores as Cores;
// TODO: 20-1-2017 - Need to do form test

if (isset($_REQUEST['run'])){
    $form = new Cores\_Form();
    $form 
    -> post ('name') 
    -> post('age');
    print_r($form);
}
?>

<form method='post' action="?run">
    <input type="text" name="name"/>
    <input type="text" name="age"/>
    
    <input type="submit">
</form>