<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">

<meta name="robots" content="noindex" />

<meta name="google-site-verification" content="<?php echo $GLOBALS['_Security'] -> GetKey('googleSiteVerficationKey');?>" />

<?php 
if (!empty($this -> meta)){ // Add on meta
    foreach ($this -> meta as $meta){
        echo '<meta '.$meta.'/>';
    }
}
?>

<link rel="alternate" hreflang="<?php echo strtolower($GLOBALS['_Session'] -> Get('Language') -> symbol.'-'.json_decode ( $GLOBALS['_Site'] ->GetIPDetails(), true )['country']) ?>" href="<?php echo $GLOBALS['_Site'] -> GetUrl();?>" />