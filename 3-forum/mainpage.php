<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php 
	include ('dbconn.php');
	include ('header.php');
?>

<title> Mainpage </title>

<style type="text/css">
body{
	background-image: url(css/sunny-bottom-view-of-high-tropical-palms-picjumbo-com.jpg); 
	background-size: cover;	
	background-repeat: no-repeat; 	
}

table{  
	font-family: Verdana, sans-serif;
	border-collapse: collapse;
    color: #4682B4;
    background:rgba(255,255,255,0.8);
    padding: 10px 20px 10px 20px;    
    -webkit-box-shadow: 0 2px 10px rgba(255,255,255,0.8);
    -moz-box-shadow: 0 2px 10px rgba(255,255,255,0.8);
  	box-shadow: 0 2px 10px rgba(250,250,255,0.8);
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

input[type=submit] {
    background-color: #4682B4;
    color: white;
    padding: 10px 20px;
    margin: 3px 0;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-size: 18px;
    font-family: Verdana, sans-serif;
    height: 40px; 
    width: 140px;
}

</style>
</head>

<body>
<br><h1 align='center' style="color:white;"> Categories </h1><br>

<table align='center'>
<tr><th>No.</th><th style='text-align: left'>Categories</th><th>Detail</th><th>Topic Total</th><th>Date Created</th></tr>

<?php 	
	// Select all the catID from the table of categories
	$Query_CatID = "SELECT catID FROM categories";
	$userQuery_CatID = mysqli_query($connect, $Query_CatID);
	$catIDNum = mysqli_num_rows($userQuery_CatID);
	
	if($catIDNum == 0){
		echo "<tr><td colspan=3><br>No categories!<br><br></td></tr>";
	}else{	
		$catNum = 1;
		while($catIDAarray = mysqli_fetch_assoc($userQuery_CatID)){
			$catID = $catIDAarray['catID'];
			
			// Count the amount of topics under each category
			$Query_CountTopic = "SELECT count(*) AS topicTotal FROM topics WHERE catID_FK = '$catID'";
			$userQuery_CountTopic = mysqli_query($connect, $Query_CountTopic);
			$topicTotalAarray = mysqli_fetch_assoc($userQuery_CountTopic);
			$topicTotal = $topicTotalAarray['topicTotal'];
			
			// Get the title, detail and date of each category
			$Query_CatTitle = "SELECT * FROM categories WHERE catID = '$catID'";
			$userQuery_CatTitle = mysqli_query($connect, $Query_CatTitle);
			$catTitleAarray = mysqli_fetch_assoc($userQuery_CatTitle);
			$catTitle = $catTitleAarray['title'];
			$catDetail = $catTitleAarray['detail'];
			$catDate = $catTitleAarray['dateCreated'];
			
			echo "<tr>	
	    			<td>".$catNum."</td>
	    			<td style='text-align: left'><a href='categories.php?catID=".$catID."'>".$catTitle."</a></td>
					<td style='text-align: left'>".$catDetail."</td>
					<td>".$topicTotal."</td>
					<td>".$catDate."</td>
				</tr>";
			$catNum++;
		}
		
	}
?>
</table><br><br><br><br><br><br>
</body>
</html>