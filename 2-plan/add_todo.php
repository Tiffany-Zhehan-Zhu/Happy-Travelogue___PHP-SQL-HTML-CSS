<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type='text/css' rel='stylesheet' href='css/add_todo.css'/>
<script   src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<title> Add To Do </title>
</head>

<body>

<div id="myDIV" class="todolistHeader">
  <h2 style="margin:5px">My To Do List</h2>
  <input type="text" id="myInput" placeholder="To do item...">
  <span onclick="newElement()" class="addBtn">Add</span>
</div>

<ul id="myUL">
	<!-- users will add items to the to do list -->
</ul>

<script>
// Create a "close" button and append it to each list item
var myNodelist = document.getElementsByTagName("LI");
var i;
for (i = 0; i < myNodelist.length; i++) {
  var span = document.createElement("SPAN");
  var txt = document.createTextNode("\u00D7");
  span.className = "close";
  span.appendChild(txt);
  myNodelist[i].appendChild(span);
}

// Click on a close button to hide the current list item
var close = document.getElementsByClassName("close");
var i;
for (i = 0; i < close.length; i++) {
  close[i].onclick = function() {
    var div = this.parentElement;
    div.style.display = "none";
  }
}

// Add a "checked" symbol when clicking on a list item
var list = document.querySelector('ul');
list.addEventListener('click', function(ev) {
  if (ev.target.tagName === 'LI') {
    ev.target.classList.toggle('checked');
  }
}, false);

// Create a new list item when clicking on the "Add" button
function newElement() {
  var li = document.createElement("li");
  var inputValue = document.getElementById("myInput").value;
  var t = document.createTextNode(inputValue);
  li.appendChild(t);
  if (inputValue === '') {
    alert("You must write something!");
  } else {
    document.getElementById("myUL").appendChild(li);
  }
  document.getElementById("myInput").value = "";
  	
  var span = document.createElement("SPAN");
  var txt = document.createTextNode("\u00D7");
  span.className = "close";
  span.appendChild(txt);
  li.appendChild(span);

  for (i = 0; i < close.length; i++) {
    close[i].onclick = function() {
      var div = this.parentElement;
      div.style.display = "none";
    }
  }

}




</script>


<!-- "save" button-->		
<table align="center">
<form action="" method="post"> 
	<tr><td align="center"><input type="text" name="listName" placeholder="Name of list..."></td></tr>
	<tr><td align="center"><input class="addBtn" name="saveButton" type="submit" value="Save"></td></tr>
</form>
</table>
<?php 
	session_start();
	include ('dbconn.php'); 
	
	$listName = $dateCreated = $userID = $listItemAarray = "";

	if ($_POST){ 
		
		$listName = $_POST["listName"];
		$dateCreated = date("m/d/Y H:i:s");
		$userID = $_SESSION['userID'];
		$listItemAarray = $_POST["listItem"];
		
		echo "listName: $listName, <br>dateCrated: $dateCreated, <br>userID: $userID, <br>listItemAarray: $listItemAarray";
		
		// Insert into table of todolist
		$sql = "INSERT INTO todolist (listName, dateCreated, userID)
		VALUES ('$listName', '$dateCreated', '$userID')";
			
		if (!mysqli_query($connect, $sql)){
			echo '<script> alert("Sorry, failed to connect to the database!"); </script>';
		}else{		
			// get the ID of the new todolist
			if (mysqli_query($connect, $sql_todolistID)){
				$sql_todolistID = "SELECT listID FROM todolist WHERE dateCreated='$dateCreated' AND userID='$userID'";
				$sql_todolistID_rs = mysqli_query($connect, $sql_todolistID);
				$data = mysqli_fetch_array($sql_todolistID_rs, MYSQLI_NUM);
				$todolistID = $data[0];
				
				while ($listItemAarray){
					$listItem = $listItemAarray['item'];
					// Insert into table of todolist_home
					$sql2 = "INSERT INTO todolistItem (listID, item)
					VALUES ('$listID', '$item')";
				}
			
				if (!mysqli_query($connect, $sql2)){
					echo '<script> alert("Sorry, failed to save this to do list!"); </script>';
				}else{	
					echo '<script> alert("Success! This to do list has been saved"); </script>';
				}		
			}
		}
	}
	mysqli_close($connect);			
?>


</body>
</html>


