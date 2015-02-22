<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Change Your Password</title>
</head>

<body>

<?php
if (toValidate()){	
	// Connect to your database software
	$con = mysql_connect('localhost','lxy','1320');
	// check if connection fails
	if(!$con){
		die ('Could not connect to database'.mysql_error() );
	}

	// Select a database
	mysql_select_db('company571',$con);
	

	//modify
	$sql="UPDATE Customer SET password=password('".$_POST['password']."') WHERE customerID='".$_POST['customerID']."'";
	$result=mysql_query($sql,$con);
	if (!$result){
		echo '<script>alert("Error:Duplicate username");history.go(-1);</script>';
	}
	echo '<script>alert("Password modified"); window.location="login.php";</script>';
	
	mysql_close($con);
}
else{
	die('Not validated');
}

?>
<?php
function toValidate(){
	$b = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
	return $b;
}
?>

</body>
</html>