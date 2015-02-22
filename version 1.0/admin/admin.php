<?php 
session_start(); 

if ($_SESSION['username']==null || $_SESSION['username']==''){
	session_destroy();
	echo '<script>window.alert("You have not logged in. Please re-login.");</script>';
	echo "<script>window.location='/hw2/login.php';</script>";
}
if($_SESSION['userType']!='admin'){
	session_destroy();
	echo '<script>window.alert("You have no permission of admin. Please re-login.");</script>';
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
<title>Admin</title>
</head>

<body>
<form action="/hw2/employeeSide/logout.php">
	<input type="submit" name="logout" value="Logout" />
</form>
<h1>ADMINISTRATOR MAIN PAGE</h1>

<h2>Manage User Information</h2>
<form action="addModifyUserForm.php" style="display:inline">
	<input type="submit" name="addUser" value="Add User"/>
</form>

<form action="modifyDeleteUser.php" method="POST" style="display:inline">
	<input type="submit" name="modifyUser" value="Modify User"/>
	<input type="submit" name="deleteUser" value="Delete User"/>
</form>

<br/><br/>

<table>
<tr><th>Username</th><th>User Type</th><th>First Name</th><th>Last Name</th><th>Payment</th><th>Phone Number</th><th>Email</th></tr>

<?php 
$sql="select * from Users";

$con = mysql_connect('localhost','lxy','1320');
if(!$con){
	die ('Could not connect to database'.mysql_error() );
}
mysql_select_db('company571',$con);
$res = mysql_query($sql);
	
while(   $row=mysql_fetch_assoc($res) ) {
	echo '<tr><td>'.$row['username'].'</td><td>'.$row['userType'].'</td><td>'.$row['firstName'].'</td><td>'.$row['lastName'].'</td><td>'.$row['payment'].'</td><td>'.$row['phone'].'</td><td>'.$row['email'].'</td></tr>';

}
echo '</table>';
// At the end of your PHP script
mysql_close($con);
?>


</body>
</html>