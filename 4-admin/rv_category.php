<?php 
	include ('dbconn.php');
	include ('header.php');
?>

<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type='text/css' rel='stylesheet' href='css/reviews_delete.css'/>
<title> Review Categories </title>
</head>

<body>
<br><h1 align='center' style="color:white;"> Categories </h1><br>

<table align='center'>
<tr><th>No.</th><th>Category ID</th><th style='text-align: left'>Categories</th><th>Topic Total</th><th>Date Created</th></tr>

<?php 	
	$catID = $catIDErr = "";
	
	if (isset($_POST["catID"]) && isset($_POST["deleteButton"])) {
	
			$catID = $_POST["catID"];
				
			if (!is_numeric($catID)) {
				$catIDErr = "<br>Please input a valid ID!";
				echo '<script> alert("Please input a valid ID!"); </script>';
			}
	
			// Match the valid input of catID with data in the database
			if ($catIDErr==""){
				$query = "SELECT * FROM categories WHERE catID = '$catID'";
				$catQuery = mysqli_query($connect, $query);
				$returned_rows = mysqli_num_rows($catQuery);
					
				if($returned_rows == 0){
					echo '<script> alert("The ID does not existed!"); </script>';
				}else{
					$sql = "DELETE FROM categories WHERE catID='$catID'";
					if (!mysqli_query($connect, $sql)){
						echo '<script> alert("Sorry, failed to delete this category."); </script>';
					}
					mysqli_free_result($result);
	
				}
			}
	}


	// Select all the catID from the table of categories
	$Query_CatID = "SELECT catID FROM categories";
	$userQuery_CatID = mysqli_query($connect, $Query_CatID);
	$catIDNum = mysqli_num_rows($userQuery_CatID);
	
	if($catIDNum == 0){
		echo "<tr><td colspan=5><br>No categories!<br><br></td></tr>";
	}else{	
		$catNum = 1;
		while($catIDAarray = mysqli_fetch_assoc($userQuery_CatID)){
			$catID = $catIDAarray['catID'];
			
			// Count the amount of topics under each category
			$Query_CountTopic = "SELECT count(*) AS topicTotal FROM topics WHERE catID_FK = '$catID'";
			$userQuery_CountTopic = mysqli_query($connect, $Query_CountTopic);
			$topicTotalAarray = mysqli_fetch_assoc($userQuery_CountTopic);
			$topicTotal = $topicTotalAarray['topicTotal'];
			
			// Get the title of each category
			$Query_CatTitle = "SELECT title FROM categories WHERE catID = '$catID'";
			$userQuery_CatTitle = mysqli_query($connect, $Query_CatTitle);
			$catTitleAarray = mysqli_fetch_assoc($userQuery_CatTitle);
			$catTitle = $catTitleAarray['title'];
			
			// Get the date of each category created
			$Query_catDate = "SELECT dateCreated FROM categories WHERE catID = '$catID'";
			$userQuery_catDate = mysqli_query($connect, $Query_catDate);
			$catDateAarray = mysqli_fetch_assoc($userQuery_catDate);
			$catDate = $catDateAarray['dateCreated'];
			
			echo "<tr><td>".$catNum."</td><td>".$catID."</td><td style='text-align: left'><a href='rv_dlt_topics.php?catID=".$catID."'>".$catTitle."</a></td><td>".$topicTotal."</td><td>".$catDate."</td></tr>";
			$catNum++;
		}
		echo "<tr><td style='text-align: left' colspan=5>
					<span class='glyphicon glyphicon-plus'></span>
					<a href='add_category.php'><strong> Create a New Category </strong></a>
			</td></tr>";
		echo "<tr><td style='text-align: left' colspan=5><form action='' method='post'>
						<span class='glyphicon glyphicon-remove'></span><strong> Delete a Category </strong>
						<input name='catID' type='text' size='30' id='catID' placeholder='Enter the ID here' required>
						<input name='deleteButton' type='submit' value='Delete'></form>
			</td></tr>";
	}
?>
</table><br><br><br><br><br><br>
</body>
</html>




