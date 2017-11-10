<?php 
	session_start();
	include ("header.php");
	include ("dbconn.php");
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type='text/css' rel='stylesheet' href='css/register_login.css'/>
<title> Login </title>
</head>

<body>
<center>
<h2 align='center' style="color:white;"><br> Welcome to <span style="font-style: italic">Happy Travelogue Forum </span>!</h2><br>

<?php 

	$nameErr = $pswdErr = $Error = "";
	
	if ($_POST) {
		
		// When the user doesn't input an username or password
		if (empty($_POST["username"]) || empty($_POST["password"])){
			$Error = "<br><br>Please input username and password.";
		} 
		
		// When the user input both the username and password
		else if (isset($_POST["username"]) && isset($_POST["password"])){
			
			$username = $_POST["username"];
			$password = $_POST["password"];
			$pname = "/^[a-zA-Z\s]*$/";	
			
			$username_length = strlen($username);
			$password_length = strlen($password);
			
			// Validate the user's input
			if ((!preg_match($pname, $username)) || $username_length<3 || $username_length>8) {
				$nameErr = "<br>Only 3-8 letters allowed for name!<br>";
			}
			if ((!preg_match($pname, $password)) || $password_length<3 || $password_length>8) {
				$pswdErr = "<br>Only 3-8 letters allowed for password!";
			}
			
			// Match the valid input of username and password with data in the database		 
			if ($nameErr=="" && $pswdErr==""){
				$query = "SELECT userID
						  FROM users
						  WHERE username = '$username' AND password = '$password'";
				$userQuery = mysqli_query($connect, $query);
				$returned_rows = mysqli_num_rows($userQuery);
				
				if($returned_rows == 0){
					$Error = "<br><br>The username or password is incorrect!";
				}else{
					$_SESSION['username'] = $username;
					$result = mysqli_fetch_array($userQuery);
					$_SESSION['userID'] = $result['userID'];
					$_SESSION['login'] = true;
				
					header("Location: mainpage.php");
				}				
			}
			
			//Another way to match the valid input of the username and password with the data in the database
			/*
			if ($nameErr=="" && $pswdErr==""){
			
				// username and password sent from form
				$username = mysqli_real_escape_string($connect,$_POST['username']);
				$password = mysqli_real_escape_string($connect,$_POST['password']);
					
				$sql = "SELECT userID
				FROM users
				WHERE username = '$username' AND password = '$password'";
				$result = mysqli_query($connect,$sql);
				$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
				$active = $row['active'];
				$count = mysqli_num_rows($result);
					
				// If result matched $username and $password, table row must be 1 row
				if($count == 1) {
					session_register("myusername");
					$_SESSION['username'] = $username;
					header("location: categories.php");
				}else {
					$Error = "<br>Your username or password is incorrect.";
				}
			}
			*/
	  				
		}
	}
	
	if ($_SESSION ['login'] == true) {
		header ( "Location: mainpage.php" );
	} else {
		$n = $p = "";
	
		if (isset ( $_POST ["username"] ) && $nameErr == "" && $Error == "") {
			$n = $username;
		}
	
		if (isset ( $_POST ["password"] ) && $pswdErr == "" && $Error == "") {
			$p = $password;
		}
	
	echo '<table>
			<form method="post" action="login.php">
			<tr><td style="padding: 8px 20px 8px 20px"><p>
					<strong> Username </strong><br>
					<input name="username" id="username" type="text" size="16" value="' . $n . '" required >
					<span style="color: #b30401; font-size: 13px; font-weight: bold; ">' . $nameErr . '</span><br><br>
	
					<strong>Password </strong><br>
					<input name="password" id="password" type="password" size="16" value="' . $p . '"; required >
					<span style="color: #b30401; font-size: 13px; font-weight: bold; ">' . $pswdErr . $Error . '</span><br><br>
			</p></td></tr>
			<tr><td align="center"><p><input type="submit" value="LOG IN" ><br><br><strong> OR </strong><br></p></td></tr>
			</form>';
	echo '<form method="post" action="mainpage.php">
			<tr><td style="padding: 5px 20px 20px 20px" align="center"><input type="submit" value="View without Login" ></td></tr>
		</form>
		</table><br><br><br><br><br><br><br>';
	}
?>

<center>
</body>
</html>	
	