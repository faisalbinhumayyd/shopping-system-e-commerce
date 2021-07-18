<?php

include '../check/config.php';


    $DirFunc = 'Includes/Functions/'; 
    $DirTemp = 'Includes/Temp/';
    $DirCss  = 'Layout/Css/';
    $DirJs   = 'Layout/Js/';

    include $DirFunc . 'functions.php';
    include $DirTemp . 'header.php';

    if(!isset($noNav)){ include $DirTemp . 'navbar.php';}

?>