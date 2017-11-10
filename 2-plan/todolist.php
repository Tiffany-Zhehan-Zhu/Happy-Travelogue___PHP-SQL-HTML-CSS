<?php 
	session_start(); 
	include ('dbconn.php');
	include ('header.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type='text/css' rel='stylesheet' href='css/todolist.css'/>
<title> My To Do List </title>
</head>

<body>
<p style="padding-left: 16px;">
	<span style="color: #4682B4; font-size: 22px;" class="glyphicon glyphicon-hand-left"></span>
	<a style="color: #4682B4;" href="todohistory.php">Back to review my lists</a>
</p>
<?php 
	//Get the url id
	if(empty($_GET['listID'])){
		$listID = "";
	}else{
		$listID=$_GET['listID'];
		$_SESSION['listID'] = $listID;
	}
	
	// Get the name of the todolist
	$Query_listName = "SELECT listName FROM todolist WHERE listID = '$listID'";
	$userQuery_listName = mysqli_query($connect, $Query_listName);
	$listNameAarray = mysqli_fetch_assoc($userQuery_listName);
	$listName = $listNameAarray['listName'];
	
	// Add button allows user to add an item to the list
	$item = "";
	if (isset($_POST["item"]) && isset($_POST["addButton"])) {
			$item = $_POST["item"];
			$sql = "INSERT INTO todolistItem (listID, item, status) VALUES ('$listID', '$item', 'New')";
	
			if (!mysqli_query($connect, $sql)){
				echo '<script> alert("Sorry, failed to save this item to do list!"); </script>';
			}else{
			}
			mysqli_close();
	}

	
	// Display each item in the todolist
	echo "<center>
				<h2><span style='color: #4682B4; font-weight: bold;'> $listName </span></h2><br>
				<table>
					<tr>
						<th>No.</th>
						<th>To Do Item</th>
						<th>Status</th>
						<th>Update Status</th>
						<th>Action</th>
					</tr>";
	
	// Get the item in the to do list
	$Query_listItem = "SELECT * FROM todolistItem WHERE listID = '$listID'";
	$userQuery_listItem = mysqli_query($connect, $Query_listItem);
	
	if (!$userQuery_listItem){
		echo '<script> alert("We are not able to get your list."); </script>';
	}else{
		// If the sql works
		$listNum = 1;
		while ($listItemAarray = mysqli_fetch_assoc($userQuery_listItem)){
			$listItem = $listItemAarray['item'];
			$status = $listItemAarray['status'];
			$itemID = $listItemAarray['itemID'];
			
			// Update status button allows user to change the status
			if ($_POST["actButton1$itemID"] || $_POST["actButton2$itemID"] || $_POST["actButton3$itemID"] ){
			
				if (isset ( $_POST ["actButton1$itemID"] )) { $status = "New"; } 			
				if (isset ( $_POST ["actButton2$itemID"] )) { $status = "In Progress"; } 			
				if (isset ( $_POST ["actButton3$itemID"] )) { $status = "Done"; } 
			
				$sql_status = "UPDATE todolistItem SET status= '$status' WHERE itemID='$itemID'";
					
				if (!mysqli_query ( $connect, $sql_status)) {
					echo '<script> alert("Sorry, failed to update the status!"); </script>';
				} 
			}			
		
			// Set different colors to the buttons indicate status
			if ($status == "Done") {
				$clrNew = "#C0C0C0";
				$clrIn = "#C0C0C0";
				$clrDone = "#20B2AA";
			} else if ($status == "In Progress") {
				$clrNew = "#C0C0C0";
				$clrIn = "#20B2AA";
				$clrDone = "#C0C0C0";
			} else if ($status == "New") {
				$clrNew = "#20B2AA";
				$clrIn = "#C0C0C0";
				$clrDone = "#C0C0C0";
			}
			
			// Put all data in a table
			echo "<tr>
						<td style='font-weight: bold;'>" . $listNum . "</td>
						<td style='text-align: left; font-weight: bold;'>" . $listItem. "</td>
						<td style='font-weight: bold;'>" . $status. "</td>
						<td><form action='' method='post'><input name='actButton1$itemID' type='submit' style='width:100px; background-color: $clrNew;' value='New'></form>
							<form action='' method='post'><input name='actButton2$itemID' type='submit' style='width:100px; background-color: $clrIn;' value='In Progress'></form>
							<form action='' method='post'><input name='actButton3$itemID' type='submit' style='width:100px; background-color: $clrDone;' value='Done'></form>							
						</td>
						<td><form action='' method='post'><input name='deleteButton$itemID' type='submit' style='width:100px' value='Delete'></form></td>
				</tr>";
			$listNum++;
			
			
			// Delete button allows user to add an item to the list
			if (isset ( $_POST ["deleteButton$itemID"] )) {			
				$sql_dlt = "DELETE FROM todolistItem WHERE itemID='$itemID'";
			
				if (!mysqli_query ( $connect, $sql_dlt )) {
					echo '<script> alert("Sorry, failed to delete this item!"); </script>';
				} 
			}
						
			
		}
		echo "<tr><form action='' method='post'> <th><span style='color: white;' class='glyphicon glyphicon-pencil'> </span></th>
				<th align=left colspan=3><input name='item' type='text' size=60 id='item' placeholder=' To do item ...' required></th>
				<th><input name='addButton' type='submit' style='width:100px; background-color: white; color: #4682B4;'  value='Add'></th></form>
			</tr>";
		echo "</table></center><br><br>";
	}
		
	
?>


</body>
</html>


