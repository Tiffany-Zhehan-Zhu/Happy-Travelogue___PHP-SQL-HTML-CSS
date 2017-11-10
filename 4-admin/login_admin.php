<?php 
	session_start();
	include ("header.php");
	include ("dbconn.php");
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type='text/css' rel='stylesheet' href='css/login.css'/>
<link href='//fonts.googleapis.com/css?family=Cantarell' rel='stylesheet'> 
<link href='//fonts.googleapis.com/css?family=Candal' rel='stylesheet'> 
<link href='//fonts.googleapis.com/css?family=Salsa' rel='stylesheet'> 
<title> Admin Login </title>
</head>

<body>
<center>
<p class="p1"> HAPPY TRAVELOGUE, HAPPY WORK </p> <br>

<?php 

$emailErr = $pswdErr = $Error = "";

if ($_POST) {

	// When the user doesn't input an email or password
	if (empty($_POST["email"]) || empty($_POST["password"])){
		$Error = "<br><br>Please input email and password.";
	}

	// When the user input both the email and password
	else if (isset($_POST["email"]) && isset($_POST["password"])){

		$email = $_POST["email"];
		$password = $_POST["password"];
		$ppswd = "/^[0-9]{3}$/";

		// Validate the user's input
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$emailErr = "<br>Invalid email format!";
		}

		if (!preg_match($ppswd, $password)) {
			$pswdErr = "<br>Only 3 numbers allowed for password!";
		}

		// Match the valid input of email and password with data in the database
		if ($emailErr=="" && $pswdErr==""){
			$query = 	"SELECT ID, name, job_title
			FROM employees
			WHERE email = '$email' AND password = '$password'";
			$userQuery = mysqli_query($connect, $query);
			$returned_rows = mysqli_num_rows($userQuery);
				
			if($returned_rows == 0){
				$Error = "<br><br>The email or password is incorrect!";
			}else{
				$_SESSION['email'] = $email;
				$result = mysqli_fetch_array($userQuery);
				$_SESSION['ID'] = $result['ID'];
				$_SESSION['name'] = $result['name'];
				$_SESSION['job_title'] = $result['job_title'];
				$_SESSION['login_admin'] = true;

				header("Location: employees.php");
			}
		}
	}
}



if ($_SESSION['login_admin'] == true){
	header("Location: employees.php");
} else {	
	$e = $p = "";
	
	if(isset($_POST["email"]) && $emailErr=="" && $Error==""){
		$e = $email;
	}
	
	if(isset($_POST["password"]) && $pswdErr=="" && $Error==""){
		$p = $password;
	}
			
	echo '<table>
			<form method="post" action="login_admin.php">
			<tr><td style="padding: 8px 20px 8px 20px"><br>
					<strong>Email </strong><br>
					<input name="email" id="email" type="text" size="16" value="'.$e.'" >
					<span style="color: #b30401; font-size: 13px; font-weight: bold; ">'.$emailErr.'</span><br><br>
			
					<strong>Password </strong><br>
					<input name="password" id="password" type="password" size="16" value="'.$p.'" >
					<span style="color: #b30401; font-size: 13px; font-weight: bold; ">'.$pswdErr.$Error.'</span><br><br>
			</td></tr>
			<tr><td align="center"><input type="submit" value="LOG IN" ><br><br><br></td></tr>
			</form>
	</table><br><br><br><br><br><br><br>';
}

?>

</center>
</body>
</html>	
	