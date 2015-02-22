<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Manage Customer</title>
</head>

<body>

<?php
$customerID="";
if(isset($_POST['customerID'])){
	$customerID=$_POST['customerID'];
}
if (toValidate()){	
	// deal with phone when add
	$phone='';
	if( filter_var($_POST['phone1'],FILTER_SANITIZE_STRING) && 
		filter_var($_POST['phone2'],FILTER_SANITIZE_STRING) && 
		filter_var($_POST['phone3'],FILTER_SANITIZE_STRING) ){
			$isPhone=true;
			$b = filter_var(  $_POST['phone1'],FILTER_VALIDATE_REGEXP,array( "options"=>array("regexp"=>"/^[1-9]+\d{2}$/") )  );
			$isPhone = $isPhone && $b;
			
			$b = filter_var(  $_POST['phone2'],FILTER_VALIDATE_REGEXP,array( "options"=>array("regexp"=>"/^\d{3}$/") )  );	
			$isPhone = $isPhone && $b;	
	
			$b = filter_var(  $_POST['phone3'],FILTER_VALIDATE_REGEXP,array( "options"=>array("regexp"=>"/^\d{4}$/") )  );	
			$isPhone = $isPhone && $b;	
			
			if($isPhone){
				$phone=$_POST['phone1'].'-'.$_POST['phone2'].'-'.$_POST['phone3'];
			}
	}
	
	// Connect to your database software
	$con = mysql_connect('localhost','lxy','1320');
	// check if connection fails
	if(!$con){
		die ('Could not connect to database'.mysql_error() );
	}

	// Select a database
	mysql_select_db('company571',$con);
	
	
	if($customerID==NULL || $customerID==""){
		//add
		$sql="INSERT INTO Customer (username,password,firstName,lastName,phone,email) VALUES ('".$_POST['username']."',password('".$_POST['password']."'),'".$_POST['fname']."','".$_POST['lname']."','".$phone."','".$_POST['email']."') ";
		$result=mysql_query($sql,$con);
		if (!$result){
			echo '<script>alert("Error:Duplicate username");history.go(-1);</script>';
		}
		echo '<script>alert("One record added"); window.location="login.php";</script>';
	}
	else{
		//modify
		$sql="UPDATE Customer SET username='".$_POST['username']."',password=password('".$_POST['password']."'),firstName='".$_POST['fname']."',lastName='".$_POST['lname']."',phone='".$phone."',email='".$_POST['email']."' WHERE customerID='".$_POST['customerID']."'";
		$result=mysql_query($sql,$con);
		if (!$result){
			echo '<script>alert("Error:Duplicate username");history.go(-1);</script>';
		}

		echo '<script>alert("One record modified"); window.location="login.php";</script>';
		
	}
	mysql_close($con);
}
else{
	die('Not validated');
}

?>
<?php
function toValidate(){
	$totalB = true;


	$b = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
	$totalB= $totalB && $b;

	$b = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
	$totalB= $totalB && $b;

	$b = filter_var($_POST['fname'],FILTER_SANITIZE_STRING);
	$totalB= $totalB && $b;

	$b = filter_var($_POST['lname'],FILTER_SANITIZE_STRING);
	$totalB= $totalB && $b;
	
	$b = filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);
	$totalB= $totalB && $b;
	
	return $totalB;
}
?>

</body>
</html>