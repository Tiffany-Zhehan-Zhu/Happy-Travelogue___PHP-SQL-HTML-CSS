<?php 
	include 'header.php';
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href='//fonts.googleapis.com/css?family=Cantarell' rel='stylesheet'> 
<link href='//fonts.googleapis.com/css?family=Candal' rel='stylesheet'> 
<link href='//fonts.googleapis.com/css?family=ABeeZee' rel='stylesheet'> 
<link type='text/css' rel='stylesheet' href='css/employees.css'/>
<title> Administrator </title>
</head>

<style>



</style>

<body>
<section> 
<center>
<?php
		if(isset($_SESSION['login_admin']) && $_SESSION['login_admin'] == true){
			echo '<p class="p1"> Hello, '.$_SESSION["name"].'. </p>';
			echo '<p class="p1"> You are a <span style="color: #4682B4;"> '.$_SESSION['job_title'].'</span>, you can </p><br>';
			
			if ($_SESSION["job_title"]=='manager'){	
				echo '<table>';
				echo '<tr><td class="linkButton"> <a class="option" href="rv_dlt_users.php"> Review/Delete Users </a></td></tr>';
				echo '<tr><td> <br><br> </td></tr>';
				echo '<tr><td class="linkButton"> <a class="option" href="rv_category.php"> Manage the Forum </a></td></tr>';
				echo '<tr><td> <br><br> </td></tr>';
				echo '<tr><td class="linkButton"> <a class="option" href="rv_dlt_employees.php"> Review/Delete Employees </a></td></tr>';
				echo '</table>';
			} else if ($_SESSION["job_title"]=='staff'){	
				echo '<table>';
				echo '<tr><td class="linkButton"> <a class="option" href="rv_dlt_users.php"> Review/Delete Users </a></td></tr>';
				echo '<tr><td> <br><br> </td></tr>';
				echo '<tr><td class="linkButton"> <a class="option" href="rv_category.php"> Manage the Forum  </a></td></tr>';
				echo '</table>';
			} else {
				echo '<p class="p2">Only ask your supervisors to get access to the system ...</p>';
				echo '<p class="p1"><span style="color: white;"> &#9785 </span></p>';
			}
		}
?>

</center>
</section>
</body>
</html>