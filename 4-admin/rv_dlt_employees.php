
<?php
	session_start();	
	include 'dbconn.php';
	include 'header.php';
	?>
		
<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type='text/css' rel='stylesheet' href='css/rv_dlt_employees.css'/>
<title>Employees</title>
</head>

<body>
	<?php 
	$employeeID = $employeeIDErr = "";   
	
	if ($_POST){
	
		if (isset($_POST["employeeID"]) && isset($_POST["deleteButton"])) {
	
			$employeeID = $_POST["employeeID"];
			
			if (!is_numeric($employeeID)) {
				$employeeIDErr = "<br>Please input a valid employee ID!";
				echo '<script> alert("Please input a valid employee ID!"); </script>';
			}
	
			// Match the valid input of employeeID with data in the database
			if ($employeeIDErr==""){
				$query = "SELECT * FROM employees WHERE ID = '$employeeID'";
				$employeeQuery = mysqli_query($connect, $query);
				$returned_rows = mysqli_num_rows($employeeQuery);
					
				if($returned_rows == 0){
					echo '<script> alert("The employee ID does not existed!"); </script>';
				}else{
					$sql = "DELETE FROM employees WHERE ID='$employeeID'";
					if (!mysqli_query($connect, $sql)){
						echo '<script> alert("Sorry, failed to delete this employee."); </script>';
					}else{
						echo '<script> alert("Success! The employee has been deleted."); </script>';
					}
						
					mysqli_free_result($result);	
				}
			}
		}
	}
	
	// Display employees
	echo "<center>
				<h2><span style='color: #4682B4; background-color: rgba(255,255,255,0.5); padding: 8px 8px; border-radius: 8px; font-weight: bold;'>Employees </span></h2><br>									
				<table border=1 cellpadding=10>
					<tr><td colspan=10><form action='' method='post'> <span style='color: #4682B4;'>&#9998 </span> Delete a employee
						<input name='employeeID' type='text' size='30' id='employeeID' placeholder='Enter the employee ID here' required>
						<input name='deleteButton' type='submit' value='Delete'></form>
					</td></tr>					
					<tr>
						<th>Employee ID</th>
						<th>Name</th>
						<th>Street</th>
						<th>City</th>
						<th>State</th>
						<th>Zip Code</th>
						<th>Email</th>
						<th>Password</th>
						<th>Job Title</th>
						<th>Salary</th>
					</tr>";
	
	$query =  "SELECT * FROM employees;";
	$result = mysqli_query($connect, $query);
	
	if (!$result){
		echo '<script> alert("Table of employees failed."); </script>';
	}else{
		while($row = mysqli_fetch_assoc($result)){
			echo "<tr>
						<td>" . $row['ID'] . "</td>
						<td>" . $row['name'] . "</td>
						<td>" . $row['address_street'] . "</td>
						<td>" . $row['address_city'] . "</td>
						<td>" . $row['address_state'] . "</td>
						<td>" . $row['address_zip'] . "</td>
						<td>" . $row['email'] . "</td>
						<td>" . $row['password'] . "</td>
						<td>" . $row['job_title'] . "</td>
						<td>" . $row['salary'] . "</td>					
				</tr>";
		}		
		echo "</table></center><br><br>";
	}	

?>


