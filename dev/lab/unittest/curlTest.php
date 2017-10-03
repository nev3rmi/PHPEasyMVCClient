<?php
require_once($_SERVER['DOCUMENT_ROOT']."/setting/init.core.php");

$curl = new \PHPEasy\Cores\_CUrl;

$result = $curl -> Send('http://codeasy.cf/api/License/RequestActiveLicense', array(
    'key' => 'd3d377b483a4648755257464a4b66535b213a4b2f42384f216a78466235444661454157654b477868665a55507649624a55465551515865586649595765596257665861435368754c655354645d42454d664a5b62474769487152554',
    'ip' => '113.161.65.43',
    'url' => 'http://testcodeasy.unaux.com/'
));

echo($result);




// Work
// $url = 'http://codeasy.cf/api/License/RequestActiveLicense';
// $myvars = http_build_query(array(
//     'key' => 'd3d377b483a4648755257464a4b66535b213a4b2f42384f216a78466235444661454157654b477868665a55507649624a55465551515865586649595765596257665861435368754c655354645d42454d664a5b62474769487152554',
//     'ip' => '113.161.65.43',
//     'url' => 'http://testcodeasy.unaux.com/'
// ));

// $ch = curl_init( $url );
// curl_setopt( $ch, CURLOPT_POST, 1);
// curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
// curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
// curl_setopt( $ch, CURLOPT_HEADER, 0);
// curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

// $response = curl_exec( $ch );

// echo $response;