<?php
    include 'init.php';
    $noNav = '';
	session_start(); 
	session_unset();
	session_destroy(); 
    $Msg = "<div class='container alert alert-info'>تم تسجيل خروجك بنجاح</div>";
    redirectHome($Msg,"../index.php",3);
	exit();