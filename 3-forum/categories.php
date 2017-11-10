<?php 
	session_start(); 
	include ('dbconn.php');
	include ('header.php');
?>
<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Category</title>

<style type="text/css">
body{
	background-image: url(css/background_categories.JPG); 
	background-size: cover;	
	background-repeat: no-repeat; 	
}

table{  
	font-family: Verdana, sans-serif;
	border-collapse: collapse;
    color: #4682B4;
    background:rgba(255,255,255,0.5);
    padding: 10px 10px 10px 10px;    
    -webkit-box-shadow: 0 2px 10px rgba(255,255,255,0.5);
    -moz-box-shadow: 0 2px 10px rgba(255,255,255,0.5);
  	box-shadow: 0 2px 10px rgba(250,250,255,0.5);
}

td, th {
	text-align: center;
    border: 5px double #ddd;
    padding: 8px 18px 8px 20px;
}

th {
    padding-top: 12px;
    padding-bottom: 12px;
    background-color: #4682B4;
    color: white;
}

tr:nth-child(even){background-color: #f2f2f2;}
tr:hover {background-color: #ddd;}

</style>
</head>

<body>
<p style="padding-left: 16px;">
	<span style="color: white; font-size: 22px;" class="glyphicon glyphicon-hand-left"></span>
	<a style="color: white;" href="mainpage.php">Back to categories</a>
</p>
<?php 
	
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
	
	echo "<h2 align='center' style='color:white;'> Topic - ".$catTitle."</h2><br>";
	echo "<table align='center' >";
	echo "<tr><th>No.</th><th style='text-align: left'>Topic Titles</th><th>Replies</th><th>Topic Creator</th><th>Date Created</th><tr>";
	
	// Select all the topicID from the table of categories
	$Query_TopicID = "SELECT topicID FROM topics WHERE catID_FK = '$catID'";
	$userQuery_TopicID = mysqli_query($connect, $Query_TopicID);
	$topicIDNum = mysqli_num_rows($userQuery_TopicID);
	
	if($topicIDNum == 0){
		echo "<tr><td colspan=5><br>No topics!<br><br></td></tr>";
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
					<td style='text-align: left'><a href='topics.php?topicID=".$topicID."'>".$topicTitle."</a></td>
					<td>".$replyTotal."</td>
					<td>".$topicCreator."</td>
					<td>".$topicDate."</td>
				</tr>";
			$topicNum++;
		}
		
	}

	if ($_SESSION["login"] == true){
		echo "<tr><td style='text-align: left' colspan=5 ><a href='create_topic.php'><strong>Create New Topic</strong> </a></td></tr>";
		echo "</table><br><br><br><br><br><br>";
	}else{
		echo "<tr><td style='text-align: left' colspan=5 >Want to create a topic? You must <a href='login.php'><strong>Log in</strong></a> firstly.</td></tr>";
		echo "</table><br><br><br><br><br><br>";
	}
	
?>

</body>
</html>