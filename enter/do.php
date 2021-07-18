<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);

$dsn = 'mysql:host=localhost;dbname=u585511470_malek';
$user = 'u585511470_malek';
$pass = 'A7mdsayed';
$option = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',);
try {
    $con = new PDO($dsn, $user, $pass, $option);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e) {echo 'Failed To Connect' . $e->getMessage();}

if($_SERVER['REQUEST_METHOD']=='POST'){
    if($_POST['type']=='signup'){
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $full=$fname." ".$lname;
        $stmt = $con->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute(array($email));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if ($count == 0) {
            $stmt = $con->prepare("INSERT INTO `users` (`user_id`, `fullname`, `email`, `password`, `status`) VALUES (NULL, ?, ?, ?,'1') ");
            $stmt->execute(array($full,$email,$password));
            header("Location: index.php?result=Account Created Successfully");
        }else{
            header("Location: index.php?result=This Email Exsist Already");
        }
    }else if($_POST['type']=='login'){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $stmt = $con->prepare("SELECT * FROM users WHERE email = ? AND password=? LIMIT 1");
        $stmt->execute(array($email,$password));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if ($count > 0) {
            $_SESSION['uid'] = $row['user_id'];
            header("Location: ../site/index.php");
        }else{
            header("Location: index.php?result=Sorry, Wrong Data");
        }
    }else if($_POST['type']=='forget'){
        $email = $_POST['email'];
        $stmt = $con->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute(array($email));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if ($count > 0) {
            header("Location: index.php?result=Password: ".$row['password']);
        }else{
            header("Location: index.php?result=Sorry, Wrong Data");
        }
    }
}
?>