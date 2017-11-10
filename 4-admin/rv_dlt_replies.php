<?php 
	include ('dbconn.php'); 
	include ('header.php');
?>

<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type='text/css' rel='stylesheet' href='css/reviews_delete.css'/>
<title>Topic</title>
</head>

<body>

<?php 	

$dltReplyID = $dltReplyIDErr = "";

if ($_POST){

	if (isset($_POST["dltReplyID"]) && isset($_POST["deleteButton"])) {

		$dltReplyID = $_POST["dltReplyID"];

		if (!is_numeric($dltReplyID)) {
			$dltReplyIDErr = "<br>Please input a valid reply ID!";
			echo '<script> alert("Please input a valid reply ID!"); </script>';
		}

		// Match the valid input of dltReplyID with data in the database
		if ($dltReplyIDErr==""){
			$query = "SELECT * FROM replies WHERE replyID = '$dltReplyID'";
			$dltReplyQuery = mysqli_query($connect, $query);
			$returned_rows = mysqli_num_rows($dltReplyQuery);
				
			if($returned_rows == 0){
				echo '<script> alert("The reply ID does not existed!"); </script>';
			}else{
				$sql = "DELETE FROM replies WHERE replyID='$dltReplyID'";
				if (!mysqli_query($connect, $sql)){
					echo '<script> alert("Sorry, failed to delete this reply."); </script>';
				}
				mysqli_free_result($result);
			}
		}
	}
}

	//Get the url id
	if(empty($_GET['topicID'])){
		$topicID = "";
	}else{
		$topicID=$_GET['topicID'];
		$_SESSION[topicID]=$topicID;
	}
	
	
	// Get the title, detail and catID of the current topic
	$Query_topicTitle = "SELECT title, detail, catID_FK FROM topics WHERE topicID = '$topicID'";
	$userQuery_topicTitle = mysqli_query($connect, $Query_topicTitle);
	$topicTitleAarray = mysqli_fetch_assoc($userQuery_topicTitle);
	
	$topicTitle = $topicTitleAarray['title'];
	$topicDetail = $topicTitleAarray['detail'];
	$catID = $topicTitleAarray['catID_FK'];
	
	echo '<p style="padding-left: 16px;">';
	echo '<span style="color: white; font-size: 22px;" class="glyphicon glyphicon-hand-left"></span>';
	echo '<a style="color: white;" href="rv_dlt_topics.php?catID='.$catID.'"> Back to topics</a>';
	echo '</p>';
	
	echo "<h2 align='center' style='color:white;'>Replies</h2><br>";
	echo "<table align='center'>";	
	echo "<tr><td style='text-align: left; background-color: #f2f2f2' colspan=5><strong> Topic ID </strong>: ".$topicID."</td></tr>";
	echo "<tr><td style='text-align: left; background-color: #f2f2f2' colspan=5><strong> Title </strong>: ".$topicTitle."</td></tr>";
	echo "<tr><td style='text-align: left; background-color: #f2f2f2' colspan=5><strong> Detail </strong>: ".$topicDetail."</td></tr>";

	echo "<tr><th>No.</th><th>Reply ID</th><th>Comments</th><th>User</th><th>Date Replied</th><tr>";
	
	// Select all the reply ID from the table of topics
	$Query_replyID = "SELECT replyID FROM replies WHERE topicID_FK = '$topicID'";
	$userQuery_replyID = mysqli_query($connect, $Query_replyID);
	$replyIDNum = mysqli_num_rows($userQuery_replyID);
	
	if($replyIDNum == 0){
		echo "<tr><td colspan=5><br>No replies!<br><br></td></tr>";
	}else{
		$replyNum = 1;
		while($replyIDAarray = mysqli_fetch_assoc($userQuery_replyID)){
			$replyID = $replyIDAarray['replyID'];
				
			// Get the comment of each reply
			$Query_comment = "SELECT comment FROM replies WHERE replyID = '$replyID'";
			$userQuery_comment = mysqli_query($connect, $Query_comment);
			$commentAarray = mysqli_fetch_assoc($userQuery_comment);
			$comment = $commentAarray['comment'];
				
			// Get the creator of each comment
			$Query_replyCreator = "SELECT u.username AS Creator
									FROM replies r
									INNER JOIN users u ON r.userID_FK = u.userID
									WHERE replyID = '$replyID'";
			$userQuery_replyCreator = mysqli_query($connect, $Query_replyCreator);
			$replyCreatorAarray = mysqli_fetch_assoc($userQuery_replyCreator);
			$replyCreator = $replyCreatorAarray['Creator'];
				
			// Get the date of each reply created
			$Query_replyDate = "SELECT dateCreated FROM replies WHERE replyID = '$replyID'";
			$userQuery_replyDate = mysqli_query($connect, $Query_replyDate);
			$replyDateAarray = mysqli_fetch_assoc($userQuery_replyDate);
			$replyDate = $replyDateAarray['dateCreated'];
			
			echo "<tr><td>".$replyNum."</td><td>".$replyID."</td><td>".$comment."</td><td>".$replyCreator."</a></td><td>".$replyDate."</td></tr>";
			$replyNum++;
		}
		echo "<tr><td style='text-align: left' colspan=5><form action='' method='post'>
						<span class='glyphicon glyphicon-remove'></span><strong> Delete a Reply </strong>
						<input name='dltReplyID' type='text' size='30' id='dltReplyID' placeholder='Enter the reply ID here' required>
						<input name='deleteButton' type='submit' value='Delete'></form>
				</td></tr>";
		}
		echo "</table><br><br><br><br><br><br>";

?>

</body>
</html>