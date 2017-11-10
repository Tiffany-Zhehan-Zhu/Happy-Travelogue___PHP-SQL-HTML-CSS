<?php 
	session_start();
	include ("header.php");
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title> Create Reply </title>

<style type="text/css">

body{
	background-image: url(css/a-road-through-rocks-picjumbo-com.jpg); 
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

th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: center;
    background-color: #4682B4;
    color: white;
}

td {
	text-align: center;
    padding: 10px 8px 10px 18px;
}

input[type=text] {
    margin: 8px 0;
    box-sizing: border-box;
    border: 2px solid #ccc;
    -webkit-transition: 0.5s;
    transition: 0.5s;
    outline: none;
    border-radius: 6px;
    font-size:18px;
    font-family: Helvetica;
    padding: 8px 3px 8px 3px;
}

input[type=text]:focus {
    border: 2px solid #4682B4;
}

textarea {
    margin: 8px 0;
    box-sizing: border-box;
    border: 2px solid #ccc;
    -webkit-transition: 0.5s;
    transition: 0.5s;
    outline: none;
    border-radius: 6px;
    font-size: 18px;
    font-family: Helvetica;
    padding: 8px 3px 8px 3px;
}

textarea:focus {
    border: 2px solid #4682B4;
}

input[type=submit] {
    background-color: #4682B4;
    color: white;
    padding: 10px 20px;
    margin: 3px 0;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-size: 16px;
    font-family: Verdana, sans-serif;
    height: 36px; 
    width: 100px;
}

input[type=reset] {
    background-color: #4682B4;
    color: white;
    padding: 10px 20px;
    margin: 3px 0;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-size: 16px;
    font-family: Verdana, sans-serif;
    height: 36px; 
    width: 100px;
}

</style>
</head>

<body>
<?php 
	//Get the url id
	if(empty($_GET['topicID'])){
		$topicID = "";
	}else{
		$topicID=$_GET['topicID'];
		$_SESSION['topicID'] = $topicID;
	}
	
	echo '<p style="padding-left: 16px;">';
	echo '<span style="color: white; font-size: 22px;" class="glyphicon glyphicon-hand-left"></span>';
	echo '<a style="color: white;" href="topics.php?topicID='.$_SESSION['topicID'].'"> Back to topics</a>';
	echo '</p>';

?>
<form method="post" action="add_reply.php">	
	<table align="center">
	<tr><th colspan="3" text-align="center" style="border: 0px;" ><strong> Creat New Reply</strong></th></tr>
	<tr>
		<td valign="top"><br><strong>Comment</strong></td>
		<td colspan="2"><textarea name="comment" cols="39" rows="8" id="comment" required></textarea></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" name="Submit" value="Submit" /></td>
		<td><input type="reset" name="Submit2" value="Reset" /></td>
	</tr>
	</table><br><br><br><br><br><br><br><br><br>
</form>
</body>	


</html>