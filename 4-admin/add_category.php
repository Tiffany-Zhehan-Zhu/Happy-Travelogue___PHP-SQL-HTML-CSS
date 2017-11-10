<?php 
	include ("dbconn.php");
	include ("header.php");	
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type='text/css' rel='stylesheet' href='css/add_category.css'/>
<title> Create Categories </title>
</head>

<body >
<p style="padding-left: 16px;">
	<span style="color: #4682B4; font-size: 22px;" class="glyphicon glyphicon-hand-left"></span>
	<a style="color: #4682B4;" href="rv_category.php">Back to categories</a>
</p>
<?php 
	if ($_POST['Submit']){

		$title=$_POST['title'];
		$detail=$_POST['detail'];	
		$datetime=date("m/d/Y h:i:s"); 
		
		$sql = "INSERT INTO categories (title, detail, dateCreated) 
				VALUES ('$title', '$detail', '$datetime')";
		$result=mysqli_query($connect, $sql);
		
		if($result){
			echo '<script> alert("Successful! Your category has been added."); </script>';
		}else {
			echo '<script> alert("Sorry! We are not able to add your category."); </script>';
			die(mysqli_query_error());
		}
		mysql_close($connect);
	}
?>

<form id="form1" name="form1" method="post" action="">	
	<table align="center">
	<tr><th colspan="3" text-align="center"><strong> Create a New Category</strong></th></tr>
	<tr><td width="14%"><strong>Title&nbsp;&nbsp; </strong></td>
		<td colspan="2"><input name="title" type="text" id="title" size="40" required/></td>
	</tr>
	<tr>
		<td valign="top"><br><strong>Detail</strong></td>
		<td colspan="2"><textarea name="detail" cols="39" rows="8" id="detail" required></textarea></td>
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