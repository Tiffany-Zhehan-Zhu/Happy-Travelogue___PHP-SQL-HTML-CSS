<?php

	$connect = mysqli_connect("sis-teach-01.sis.pitt.edu", "zhz90", "617tiff@pitt", "zhz90");
	if(mysqli_connect_errno()){
		die("Database connection failed: ". mysqli_connect_error() ."(" . mysqli_connect_errno(). ")");
	}

?>
