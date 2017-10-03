<?php
namespace PHPEasy\Views;
?>
</div> <!-- End id="main-app" -->
<?php require_once('views/_layout/body/_footer.php')?>
<?php require_once('views/_layout/body/_css.php')?>
<?php require_once('public/css/cdnCss.php')?>
<!-- Additional Css -->
<?php 
    if (!empty($this -> css)){
        foreach ($this -> css as $css){
            echo '<link href="'.$css.'" rel="stylesheet">';
        }
    }
?>
<?php require_once('views/_layout/body/_js.php')?>
<?php require_once('public/js/cdnJs.php')?>
<!-- Additional Js -->
<?php
    if (!empty($this -> js)){
        foreach ($this -> js as $js){
            echo '<script type="text/javascript" src="'.$js.'"></script>';
        }
    }
?>
</body>
</html>