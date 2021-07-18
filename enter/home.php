<?php 
session_start(); 
if(!isset($_SESSION['uid'])){
    header("Location: index.php");
}
?>
<html>
    <head>
        <title>Home</title>
    </head>
    <body>
        <h1>Welcome</h1>
        <br/><br/><hr/>
        <a href="logout.php" >Logout</a>
    </body>
</html>