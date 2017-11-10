<?php 
	session_start();
	include ("header.php");
	include ("dbconn.php");
?>

<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Add Topic</title>

<style type="text/css">
body{
	background-image: url(css/background_categories.JPG); 
	background-size: cover;	
	background-repeat: no-repeat; 	
}

</style>
</head>

<?php 
/*	
	ob_start();
	require ("login.php");
	require ("categories.php");
	ob_end_clean();
*/	
	// get data that sent from form 
	$title=$_POST['title'];
	$detail=$_POST['detail'];	
	$userID=$_SESSION['userID'];
	$catID=$_SESSION['catID'];
	
	$datetime=date("m/d/Y h:i:s"); 
	
	$sql = "INSERT INTO topics (title, detail, dateCreated, userID_FK, catID_FK) 
			VALUES ('$title', '$detail', '$datetime', '$userID', '$catID')";
	$result=mysqli_query($connect, $sql);
	
	if($result){
		echo '<script> alert("Successful! Your topic has been added.") </script>';
		header("Refresh: 0; URL=categories.php?catID=$catID");
	}else {
		echo '<script> alert("Sorry! We are not able to add your topic.") </script>';
		header("create_topic.php");
		die(mysqli_query_error());
	}
	mysql_close($connect);
?>

</html>