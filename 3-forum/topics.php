<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php 
	include ('dbconn.php'); 
	include ('header.php');
?>

<title>Topic</title>

<style type="text/css">
	body{
		background-image: url(css/view_replies.JPG); 
		background-size: cover;	
		background-repeat: no-repeat; 	
	}
	
	table.replies{  
		font-family: Verdana, sans-serif;
		border-collapse: collapse;
	    color: #4682B4;
	    background:rgba(255,255,255,0.5);
	    padding: 10px 10px 10px 10px;    
	    -webkit-box-shadow: 0 2px 10px rgba(255,255,255,0.5);
	    -moz-box-shadow: 0 2px 10px rgba(255,255,255,0.5);
	  	box-shadow: 0 2px 10px rgba(250,250,255,0.5);
	}
	
	table.replies td, th {
		text-align: center;
	    border: 5px double #ddd;
	    padding: 8px 18px 8px 20px;
	}
	
	table.replies th {
	    padding-top: 12px;
	    padding-bottom: 12px;
	    background-color: #4682B4;
	    color: white;
	}
	table.replies tr:nth-child(even){background-color: #f2f2f2;}
	table.replies tr:hover {background-color: #ddd;}
</style>
</head>

<body>

<?php 	
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
	echo '<a style="color: white;" href="categories.php?catID='.$catID.'"> Back to topics</a>';
	echo '</p>';
	
	echo "<h2 align='center' style='color:white;'>Replies</h2><br>";
	echo "<table class='replies' align='center' >";	
	echo "<tr><td style='text-align: left; background-color: #f2f2f2' colspan=4><strong> Topic ID </strong>: ".$topicID."</td></tr>";
	echo "<tr><td style='text-align: left; background-color: #f2f2f2' colspan=4><strong> Title </strong>: ".$topicTitle."</td></tr>";
	echo "<tr><td style='text-align: left; background-color: #f2f2f2' colspan=4><strong> Detail </strong>: ".$topicDetail."</td></tr>";
	
	echo "<tr><th style='text-align: left'>No.</th><th>Comments</th><th>User</th><th>Date Replied</th><tr>";
	
	// Select all the topicID from the table of categories
	$Query_replyID = "SELECT replyID FROM replies WHERE topicID_FK = '$topicID'";
	$userQuery_replyID = mysqli_query($connect, $Query_replyID);
	$replyIDNum = mysqli_num_rows($userQuery_replyID);
	
	if($replyIDNum == 0){
		echo "<tr><td colspan=4><br>No replies!<br><br></td></tr>";
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
				
			echo "<tr><td style='text-align: left'>".$replyNum."</a></td><td>".$comment."</td><td>".$replyCreator."</a></td><td>".$replyDate."</td></tr>";
			$replyNum++;
		}
	}
	
	if ($_SESSION["login"] == true){
		echo "<tr><td style='text-align: left' colspan=4 ><a href='create_reply.php'><strong>Create New Reply</strong></a></td></tr>";
		echo "</table><br><br><br><br><br><br>";
	}else{
		echo "<tr><td style='text-align: left' colspan=4 >Want to create a reply? You must <a href='login.php'><strong>Log in</strong></a> firstly.</td></tr>";
		echo "</table><br><br><br><br><br><br>";
	}

?>

</body>
</html>