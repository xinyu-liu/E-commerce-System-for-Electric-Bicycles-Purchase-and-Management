<?php 
session_start(); 

if ($_SESSION['username']==null || $_SESSION['username']==''){
	session_destroy();
	echo '<script>window.alert("You have not logged in. Please re-login.");</script>';
	echo "<script>window.location='/hw2/login.php';</script>";
}
if($_SESSION['userType']!='employee'){
	session_destroy();
	echo '<script>window.alert("You have no permission of employee. Please re-login.");</script>';
	echo "<script>window.location='/hw2/login.php';</script>";
}
		
$thres=5*60;//second
$t=time(); 
$diff=$t-$_SESSION['startTime'];
if ($diff>$thres) {
	session_destroy();
	echo '<script>window.alert("You have logged in for '.($thres/60).' minutes. Please re-login.");</script>';
	echo "<script>window.location='/hw2/login.php';</script>";
}
				
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Employee</title>
</head>


<body>
<body>
<form action="/hw2/logout.php">
	<input type="submit" name="logout" value="Logout" />
</form>
<h1>EMPLOYEE MAIN PAGE</h1>


<form action="productManagement.php" method="POST" style="display:inline">
	<input type="submit" name="addUser" value="Manage Products"/> 
</form>

<form action="categoryManagement.php" method="POST" style="display:inline">
	<input type="submit" name="modifyUser" value="Manage Product Categories"/>
</form>

<form action="specialManagement.php" method="POST" style="display:inline">
	<input type="submit" name="deleteUser" value="Manage Special Products "/>
</form>

</body>
</html>

</body>
</html>