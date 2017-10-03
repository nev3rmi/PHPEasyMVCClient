<!-- Partial Additional Css -->
<?php 
    if (!empty($this -> css)){
        foreach ($this -> css as $css){
            echo '<link href="'.$css.'" rel="stylesheet">';
        }
    }
?>
<!-- Partial Additional Js -->
<?php
    if (!empty($this -> js)){
        foreach ($this -> js as $js){
            echo '<script type="text/javascript" src="'.$js.'"></script>';
        }
    }
?>