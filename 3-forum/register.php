<?php
	session_start();
	include ("header.php");
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type='text/css' rel='stylesheet' href='css/register_login.css'/>
<title> Register </title>
</head>

<body>
<?php 
	$username = $password = $password2 = $email = $registerResult = $registerAction = "";
	$nameErr = $pswdErr = $pswd2Err = $emailErr = $nameMatchErr = $pswdMatchErr = $emailMatchErr = "";
	
	if ($_POST) {		
			$username = $_POST["username"];
			$password = $_POST["password"];
			$password2 = $_POST["password2"];
			$email = $_POST["email"];
			$pname = "/^[a-zA-Z\s]*$/";	
			
			$username_length = strlen($username);
			$password_length = strlen($password);
			$password2_length = strlen($password2);
			
			// Validate the user's input
			if ((!preg_match($pname, $username)) || $username_length<3 || $username_length>8) {
				$nameErr = "<br>Only 3-8 letters allowed for username!<br>";
			}
			if ((!preg_match($pname, $password)) || $password_length<3 || $password_length>8) {
				$pswdErr = "<br>Only 3-8 letters allowed for password!<br>";
			}
			if ((!preg_match($pname, $password2)) || $password2_length<3 || $password2_length>8) {
				$pswd2Err = "<br>Only 3-8 letters allowed for password!<br>";
			} else {
				if($password != $password2){
					$pswd2Err = "<br>Comfirm password does not match!<br>";
				}
			}		
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$emailErr = "<br>Invalid email format!<br>";
			}						
	
			// Match the valid input of username, password and email with data in the database
			if ($nameErr =="" &&  $pswdErr =="" &&  $pswd2Err =="" &&  $emailErr =="" ) {
				include ("dbconn.php");
				
				// Check if the email is already existed in the database
				$query_email = "SELECT userID
							FROM users
							WHERE email = '$email' ";
				$sql_email = mysqli_query($connect, $query_email);
				$returned_rows_email = mysqli_num_rows($sql_email);
				
				if($returned_rows_email > 0){
					$emailMatchErr = "<br>This email has been registered. Please "."<a href='login.php'>log in</a>.<br>";
				}else{
					
					// If the email has not been registered. Check if the username has been registered.
					$query_name = "SELECT userID
					FROM users
					WHERE username = '$username'";
					
					$sql_name = mysqli_query($connect, $query_name);
					$returned_rows_name = mysqli_num_rows($sql_name);
					
					if($returned_rows_name > 0){
						$nameMatchErr = "<br>This username has been registered.<br>Please choose another one.<br>";
					} else {
						// If the username has not been registered. Add this user to the database.	
						$sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
						
						if (!mysqli_query($connect, $sql)){
							echo '<script type="text/javascript">';
							echo 'alert("Registration Failed! Please try again.");';
							echo 'window.location= "register.php";';
							echo '</script>';						
						}else{			
							echo '<script type="text/javascript">';
							echo 'alert("Registration Successful! You can log in now.");';
							echo 'window.location= "login.php";';
							echo '</script>';
						}
					}					
				}				
			}
	}// end of if($_POST)
?>

<h2 align='center' style="color:white;"><span style="font-style: italic"> Register Now </span></h2><br> 
<table align= center>
<form method="post" action="register.php">
	<tr><td style="padding: 20px 20px 10px 20px">		
		<span style="color: #b30401; font-size: 13px;">* </span><strong>Username </strong><br>
		<input name="username" id="username" type="text" size="16" required placeholder=" Only 3-8 letters allowed."
		<?php if(isset($_POST["username"]) && $nameErr=="" && $nameMatchErr=="") echo "value=$username"; ?>>
				<span style="color: #b30401; font-size: 13px;"><?php echo "$nameErr"; echo "$nameMatchErr"; ?></span><br> 
		
		<span style="color: #b30401; font-size: 13px;">* </span><strong>Password </strong><br>		
		<input name="password" id= "password" type="password" size="16" required placeholder=" Only 3-8 letters allowed."
				<?php if(isset($_POST['password']) && $pswdErr=="" ) echo "value=$password"; ?>>
				<span style="color: #b30401; font-size: 13px;"><?php echo "$pswdErr";  ?></span><br>
				
		<span style="color: #b30401; font-size: 13px;">* </span><strong>Comfirm Password </strong><br>
		<input name="password2" id= "password2" type="password" size="16" required placeholder=" Only 3-8 letters allowed."
				<?php if(isset($_POST['password2']) && $pswd2Err=="") echo "value=$password2"; ?>>
				<span style="color: #b30401; font-size: 13px;"><?php echo $pswd2Err;  ?></span><br>
		
		<span style="color: #b30401; font-size: 13px;">* </span><strong> Email </strong><br>
		<input name="email" id= "email" type="text" size="16" required
				<?php if(isset($_POST['email']) && $emailErr=="" ) echo "value=$email"; ?>>
				<span style="color: #b30401; font-size: 13px;"><?php echo "$emailErr"; echo "$emailMatchErr";?></span>		
	</td></tr>
	<tr><td style="padding: 0px 20px 20px 20px"><span style="color: #b30401;">* Indicates required fields.</span></td></tr>
	<tr><td align="center"><p><input type="submit" value="Sign Up" ><br><br></td></tr>
</form>
</table><br><br><br><br><br><br><br>

</body>
</html>
