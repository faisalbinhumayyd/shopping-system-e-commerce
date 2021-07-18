 <?php
    include 'init.php';
    $noNav = '';
	session_start(); 
    if(isset($_SESSION['type'])&&$_SESSION['type']=='user'){
        session_unset(); 
        session_destroy(); 
        header('Location: http://3dscope.net');
        exit(); 
    }else{
        session_unset(); 
        session_destroy(); 
        redirectHome($Msg,"../../index.php",3); 
        exit(); 
    }
	