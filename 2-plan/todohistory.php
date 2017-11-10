<?php 
	session_start();
	include ('dbconn.php'); 
	include ('header.php');
?>
<s!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type='text/css' rel='stylesheet' href='css/todohistory.css'/>

<title> To Do List History </title>
</head>

<body>
<center>
<h1 style="color:white;"><br> My To Do List <br></h1>
<table>
<tr><th style="text-align: center"> List </th><th style="text-align: center"> Name </th><th style="text-align: center"> Date Created </th><th>Action</th></tr><br>
<?php 

	// Add button allows user to add an listName to the list
//	$listName = "";
	if (isset($_POST["listName"]) && isset($_POST["addButton"])) {
		
		$listName = $_POST["listName"];
		$dateCreated = date("m/d/Y H:i:s");
		$userID = $_SESSION['userID'];
		
		$sql = "INSERT INTO todolist (listName, dateCreated, userID) VALUES ('$listName', '$dateCreated', '$userID')";
	
		if (!mysqli_query($connect, $sql)){
			echo '<script> alert("Sorry, failed to create a new list!"); </script>';
		}else{
		}
		mysqli_close();
	}


	// Select all the listID from the table of todolist
	$Query_listID = "SELECT t.listID
					FROM todolist t 
					INNER JOIN users u ON u.userID = t.userID
					WHERE u.username = '".$_SESSION["username"]."'";
	$userQuery_listID = mysqli_query($connect, $Query_listID);
	$listIDNum = mysqli_num_rows($userQuery_listID);
	
	if($listIDNum == 0){
		echo "<tr><td colspan=4 style='text-align: center'><br>You don't have any to do list!<br><br></td></tr>";
	}else{		
		$listNum = 1;
		while($listIDAarray = mysqli_fetch_assoc($userQuery_listID)){
			$listID = $listIDAarray['listID'];			
			//$no = array_search($listID, array_keys($listIDAarray));
			
			// Get the list name of this user
			$Query_listName = "SELECT listName FROM todolist WHERE listID = '$listID'";
			$userQuery_listName = mysqli_query($connect, $Query_listName);
			$listNameAarray = mysqli_fetch_assoc($userQuery_listName);
			$listName = $listNameAarray['listName'];
			
			// Get the date of each list created
			$Query_listDate = "SELECT dateCreated FROM todolist WHERE listID = '$listID'";
			$userQuery_listDate = mysqli_query($connect, $Query_listDate);
			$listDateAarray = mysqli_fetch_assoc($userQuery_listDate);
			$listDate = $listDateAarray['dateCreated'];
			
			echo "<tr>
					<td style='text-align: center'><span class='glyphicon glyphicon-plane'></span> $listNum</td>
					<td style='text-align: left'><a href='todolist.php?listID=".$listID."'>".$listName."</a></td>
					<td style='text-align: center'>".$listDate."</td>
					<td><form action='' method='post'><input name='deleteButton$listID' type='submit' style='width:100px' value='Delete'></form></td>
				</tr>";
			$listNum++;
			
			// Delete button allows user to add an item to the list
			if (isset ( $_POST ["deleteButton$listID"] )) {
				$sql_dlt = "DELETE FROM todolist WHERE listID='$listID'";
					
				if (!mysqli_query ( $connect, $sql_dlt )) {
					echo '<script> alert("Sorry, failed to delete this list!"); </script>';
				}
			}
			
		}
	}

	echo "<tr>
				<form action='' method='post'>
					<th><span style='color: white;' class='glyphicon glyphicon-globe'> </span></th>
					<th colspan=2><input name='listName' type='text' size=50 id='listName' placeholder=' Name for your new to do list' required></th>
					<th><input name='addButton' type='submit' style='background-color: white; color: #4682B4;'value='CREATE'></th>
				</form>
			</tr>";
?>

</table><br><br><br><br><br><br>
		
</center>
</body>
</html>



