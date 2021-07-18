<?php

include 'config.php';

    date_default_timezone_set("Asia/Riyadh");
    $LastWeek = date("Y-m-d", strtotime("-7 day"));
    $Date = date("Y-m-d");
    $Time = date("h:i:sa");

    // Paths includes
    $DirFunc = 'Includes/Functions/'; //function folder
    $DirTemp = 'Includes/Temp/'; //temp folder

    // Paths layout
    $DirCss  = 'Layout/Css/';
    $DirJs   = 'Layout/Js/';

    //Includes Important Files
    include $DirFunc . 'functions.php';
    include $DirTemp . 'header.php';

    // include navbar page expect pages (nonavbar)
    if(!isset($noNav)){ include $DirTemp . 'navbar.php';}
    
?>