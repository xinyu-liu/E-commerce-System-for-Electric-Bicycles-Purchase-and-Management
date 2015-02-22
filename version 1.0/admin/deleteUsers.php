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
<title>Untitled Document</title>
</head>

<body>
<?php


$con = mysql_connect('localhost','lxy','1320');
if(!$con){
	die ('Could not connect to database'.mysql_error() );
}
mysql_select_db('company571',$con);

$checkbox = $_POST['deleteCheckBox']; 
foreach($checkbox as $userIndex){
	$sql='DELETE FROM Users WHERE userIndex='.$userIndex.';';
	if (!mysql_query($sql,$con)){
			die('Error: ' . mysql_error());
	}
}
echo '<script>alert("User record(s) deleted"); window.location="admin.php";</script>';
mysql_close($con);

?>
</body>
</html>