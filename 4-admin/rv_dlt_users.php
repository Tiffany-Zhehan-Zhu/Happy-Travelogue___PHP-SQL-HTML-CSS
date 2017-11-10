<?php
	session_start();	
	include 'dbconn.php';
	include 'header.php';
?>
	
<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type='text/css' rel='stylesheet' href='css/rv_dlt_users.css'/>
<title>Users</title>
</head>

<body>
<?php 
	$userID = $userIDErr = "";   
	
	if ($_POST){
	
		if (isset($_POST["userID"]) && isset($_POST["deleteButton"])) {
	
			$userID = $_POST["userID"];
			
			if (!is_numeric($userID)) {
				$userIDErr = "<br>Please input a valid user ID!";
				echo '<script> alert("Please input a valid user ID!"); </script>';
			}
	
			// Match the valid input of userID with data in the database
			if ($userIDErr==""){
				$query = "SELECT * FROM users WHERE userID = '$userID'";
				$userQuery = mysqli_query($connect, $query);
				$returned_rows = mysqli_num_rows($userQuery);
					
				if($returned_rows == 0){
					echo '<script> alert("The user ID does not existed!"); </script>';
				}else{
					$sql = "DELETE FROM users WHERE userID='$userID'";
					if (!mysqli_query($connect, $sql)){
						echo '<script> alert("Sorry, failed to delete this user."); </script>';
					}else{
						echo '<script> alert("Success! The user has been deleted."); </script>';
					}
						
					mysqli_free_result($result);
	
				}
			}
		}
	}
	// Display users
	echo "<center>
				<h2><span style='color: #4682B4; background-color: rgba(255,255,255,0.5); padding: 8px 8px; border-radius: 8px; font-weight: bold;'> Users </span></h2><br>						
				<table border=1 cellpadding=5>
					<tr><td colspan=4 ><form action='' method='post'><span style='color: #4682B4;'>&#9998 </span> Delete a user
						<input name='userID' type='text' size='30' id='userID' placeholder='Enter the user ID here' required>
						<input name='deleteButton' type='submit' value='Delete'></form>
					</td></tr>					
					<tr>
						<th>User ID</th>
						<th>Username</th>
						<th>Password</th>
						<th>Email</th>
					</tr>";
	
	$query =  "SELECT * FROM users;";
	$result = mysqli_query($connect, $query);
	
	if (!$result){
		echo '<script> alert("Table of users failed."); </script>';
	}else{
		while($row = mysqli_fetch_assoc($result)){
			echo "<tr>
						<td>" . $row['userID'] . "</td>
						<td>" . $row['username'] . "</td>
						<td>" . $row['password'] . "</td>
						<td>" . $row['email'] . "</td>
				</tr>";
		}	
		echo "</table></center><br><br>";
	}	

?>

</body>
</html>


