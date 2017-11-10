<?php 
	session_start(); 
	include ('dbconn.php');
	include ('header.php');
?>

<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type='text/css' rel='stylesheet' href='css/reviews_delete.css'/>
<title> Topics </title>
</head>

<body>
<p style="padding-left: 16px;">
	<span style="color: white; font-size: 22px;" class="glyphicon glyphicon-hand-left"></span>
	<a style="color: white;" href="rv_category.php">Back to categories</a>
</p>

<?php 

	$dltTopicID = $dltTopicIDErr = "";
	
	if ($_POST){
	
		if (isset($_POST["dltTopicID"]) && isset($_POST["deleteButton"])) {
	
			$dltTopicID = $_POST["dltTopicID"];
				
			if (!is_numeric($dltTopicID)) {
				$dltTopicIDErr = "<br>Please input a valid topic ID!";
				echo '<script> alert("Please input a valid topic ID!"); </script>';
			}
	
			// Match the valid input of dltTopicID with data in the database
			if ($dltTopicIDErr==""){
				$query = "SELECT * FROM topics WHERE topicID = '$dltTopicID'";
				$dltTopicQuery = mysqli_query($connect, $query);
				$returned_rows = mysqli_num_rows($dltTopicQuery);
					
				if($returned_rows == 0){
					echo '<script> alert("The topic ID does not existed!"); </script>';
				}else{
					$sql = "DELETE FROM topics WHERE topicID='$dltTopicID'";
					if (!mysqli_query($connect, $sql)){
						echo '<script> alert("Sorry, failed to delete this topic."); </script>';
					}
					mysqli_free_result($result);
				}
			}
		}
	}


	//Get the url id
	if(empty($_GET['catID'])){
		$catID = "";
	}else{
		$catID=$_GET['catID'];
		$_SESSION['catID'] = $catID;
	}

	// Get the title of the current category
	$Query_CatTitle = "SELECT title FROM categories WHERE catID = '$catID'";
	$userQuery_CatTitle = mysqli_query($connect, $Query_CatTitle);
	$catTitleAarray = mysqli_fetch_assoc($userQuery_CatTitle);
	$catTitle = $catTitleAarray['title'];
	
	echo "<h2 align='center' style='color:white;'>Topics - ".$catTitle."</h2><br>";
	echo "<table align='center'>";
	echo "<tr><th>No.</th><th>Topic ID</th><th style='text-align: left'>Topic Titles</th><th>Replies</th><th>Topic Creator</th><th>Date Created</th><tr>";

	// Select all the topicID from the table of categories
	$Query_TopicID = "SELECT topicID FROM topics WHERE catID_FK = '$catID'";
	$userQuery_TopicID = mysqli_query($connect, $Query_TopicID);
	$topicIDNum = mysqli_num_rows($userQuery_TopicID);
	
	if($topicIDNum == 0){
		echo "<tr><td colspan=6><br>No topics!<br><br></td></tr>";
	}else{
		$topicNum = 1;
		while($topicIDAarray = mysqli_fetch_assoc($userQuery_TopicID)){
			$topicID = $topicIDAarray['topicID'];
				
			// Count the amount of replies under each topic
			$Query_CountReply = "SELECT count(*) AS replyTotal FROM replies WHERE topicID_FK = '$topicID'";
			$userQuery_CountReply = mysqli_query($connect, $Query_CountReply);
			$replyTotalAarray = mysqli_fetch_assoc($userQuery_CountReply);
			$replyTotal = $replyTotalAarray['replyTotal'];
				
			// Get the title of each topic
			$Query_topicTitle = "SELECT title FROM topics WHERE topicID = '$topicID'";
			$userQuery_topicTitle = mysqli_query($connect, $Query_topicTitle);
			$topicTitleAarray = mysqli_fetch_assoc($userQuery_topicTitle);
			$topicTitle = $topicTitleAarray['title'];
				
			// Get the creator of each topic
			$Query_topicCreator = "SELECT u.username AS Creator
									FROM topics t
									INNER JOIN users u ON t.userID_FK = u.userID
									WHERE topicID = '$topicID'";
			$userQuery_topicCreator = mysqli_query($connect, $Query_topicCreator);
			$topicCreatorAarray = mysqli_fetch_assoc($userQuery_topicCreator);
			$topicCreator = $topicCreatorAarray['Creator'];
				
			// Get the date of each topic created
			$Query_topicDate = "SELECT dateCreated FROM topics WHERE topicID = '$topicID'";
			$userQuery_topicDate = mysqli_query($connect, $Query_topicDate);
			$topicDateAarray = mysqli_fetch_assoc($userQuery_topicDate);
			$topicDate = $topicDateAarray['dateCreated'];
				
			echo "<tr>
					<td>".$topicNum."</td>
					<td>".$topicID."</td>
					<td style='text-align: left'><a href='rv_dlt_replies.php?topicID=".$topicID."'>".$topicTitle."</a></td>
					<td>".$replyTotal."</td>
					<td>".$topicCreator."</td>
					<td>".$topicDate."</td>
				</tr>";
			$topicNum++;
		}
		echo "<tr><td style='text-align: left' colspan=6><form action='' method='post'>
						<span class='glyphicon glyphicon-remove'></span><strong> Delete a Topic </strong>
						<input name='dltTopicID' type='text' size='30' id='dltTopicID' placeholder='Enter the topic ID here' required>
						<input name='deleteButton' type='submit' value='Delete'></form>
				</td></tr>";
	}
?>

</body>
</html>