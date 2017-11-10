<?php
	session_start();
	include ('header.php');	
	$_SESSION['login'] = false;
	session_destroy();
	header("Location: login_admin.php");
?>

