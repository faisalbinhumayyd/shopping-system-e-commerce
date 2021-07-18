<?php
error_reporting(E_ALL & ~E_NOTICE);
	$dsn = 'mysql:host=localhost;dbname=u585511470_malek';
	$user = 'u585511470_malek';
	$pass = 'A7mdsayed';
	$option = array(
		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
	);

	try {
		$con = new PDO($dsn, $user, $pass, $option);
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	catch(PDOException $e) {
		echo 'Failed To Connect' . $e->getMessage();
	}