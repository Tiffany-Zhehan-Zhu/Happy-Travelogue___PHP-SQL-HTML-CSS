<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Add Reply</title>
<style type="text/css">
body{
	background-image: url(css/background_categories.JPG); 
	background-size: cover;	
	background-repeat: no-repeat; 	
}

</style>
</head>

<?php 
	include ("dbconn.php");
	include ("header.php");
	
	// get data that sent from form 
	$comment=$_POST['comment'];
	$datetime=date("m/d/Y h:i:s");
	$userID=$_SESSION['userID'];
	$topicID=$_SESSION['topicID'];
	
	$sql = "INSERT INTO replies (comment, dateCreated, userID_FK, topicID_FK) 
			VALUES ('$comment', '$datetime', '$userID', '$topicID')";
	$result=mysqli_query($connect, $sql);

	if($result){
		echo '<script> alert("Successful! Your reply has been added.") </script>';
		header("Refresh: 0; URL=topics.php?topicID=$topicID");
	}else {
		echo '<script> alert("Sorry! We are not able to add your reply.") </script>';
	}
	mysql_close($connect);
?>

</html>