<?php 
session_start(); 

if ($_SESSION['username']==null || $_SESSION['username']==''){
	session_destroy();
	echo '<script>window.alert("You have not logged in. Please re-login.");</script>';
	echo "<script>window.location='/hw2/login.php';</script>";
}
if($_SESSION['userType']!='manager'){
	session_destroy();
	echo '<script>window.alert("You have no permission of manager. Please re-login.");</script>';
	echo "<script>window.location='/hw2/login.php';</script>";
}
		
$thres = 5*60;//second
$t = time(); 
$diff = $t-$_SESSION['startTime'];
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
<title>Manager</title>
</head>

<body>
<form action="/hw2/logout.php">
	<input type="submit" name="logout" value="Logout" />
</form>
<h1>MANAGER MAIN PAGE</h1>

<form action="productSearchForm.php" method="POST" style="display:inline">
	<input type="submit" value="View Products"/> 
</form>

<form action="userSearchForm.php" method="POST" style="display:inline">
	<input type="submit" value="View Users"/>
</form>

<form action="specialSearchForm.php" method="POST" style="display:inline">
	<input type="submit" value="View Special Products"/>
</form>

<form action="orderSearchForm.php" method="POST" style="display:inline">
	<input type="submit" value="View Orders"/>
</form>
</body>
</html>