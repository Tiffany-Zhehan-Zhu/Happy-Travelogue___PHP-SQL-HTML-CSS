<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
  <style type="text/css">
	ul {
	    list-style-type: none;
	    margin: 0;
	    padding: 0;
	    overflow: hidden;
	    background-color: #333;
	}
  </style>
</head>


<nav class="navbar navbar-inverse">
  <div class="container-fluid">
  
    <div class="navbar-header">
      <a class="navbar-brand" style="color:white;"> Happy Travelogue </a>
    </div>
    
    <ul class="nav navbar-nav">
      <li><a href="http://studentprojects.sis.pitt.edu/fall2016/zhz90/Finalproject/1-homepage/homepage.php">Home</a></li>
      <li><a href="http://studentprojects.sis.pitt.edu/fall2016/zhz90/Finalproject/4-admin/employees.php">Menu</a></li>
    </ul>
    
    <ul class="nav navbar-nav navbar-right">
		<?php 
		if(isset($_SESSION['login_admin']) && $_SESSION['login_admin'] == true){
			echo '<li><a href="#"> Hello, <span style="color: white;">'.$_SESSION["name"].'</span> ! </a></li>';
			echo '<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Log Out </a></li>';	
		}else{
			echo '<li><a href="login_admin.php"><span class="glyphicon glyphicon-log-in"></span>  Admin Login </a></li>';
		}
     	?> 
     </ul>     
  </div>
</nav>

    	
