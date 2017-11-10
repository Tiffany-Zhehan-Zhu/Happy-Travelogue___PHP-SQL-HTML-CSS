<?php

	$connect = mysqli_connect("localhost", "zhz90", "", "zhz90");
	if(mysqli_connect_errno()){
		die("Database connection failed: ". mysqli_connect_error() ."(" . mysqli_connect_errno(). ")");
	}

?>
