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
<title>Manage User</title>
</head>

<body>

<?php
$userIndex="";
if(isset($_POST['userIndex'])){
	$userIndex=$_POST['userIndex'];
}

/*
if($userIndex==NULL || $userIndex==""){
	echo 'add';
}
else{
	echo 'modify';
}
*/

if (toValidate()){	
	// deal with email and phone when add
	$email = '';
	if(filter_var($_POST['email'],FILTER_SANITIZE_STRING)){
		$b = filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);
		if($b){
			$email=$_POST['email'];
		}
	}
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
	
	
	if($userIndex==NULL || $userIndex==""){
		//add
		$sql="INSERT INTO Users (username,password,userType,firstName,lastName,payment,phone,email) VALUES ('".$_POST['username']."',password('".$_POST['password']."'),'".$_POST['userType']."','".$_POST['fname']."','".$_POST['lname']."','".$_POST['payment']."','$phone','$email') ";
		$result=mysql_query($sql,$con);
		if (!$result){
			echo '<script>alert("Error:Duplicate username");history.go(-1);</script>';
		}
		echo '<script>alert("One record added"); window.location="admin.php";</script>';
	}
	else{
		//modify
		$sql="UPDATE Users SET username='".$_POST['username']."',password=password('".$_POST['password']."'),userType='".$_POST['userType']."',firstName='".$_POST['fname']."',lastName='".$_POST['lname']."',payment='".$_POST['payment']."',phone='".$phone."',email='".$email."' WHERE userIndex='".$_POST['userIndex']."'";
		$result=mysql_query($sql,$con);
		if (!$result){
			echo '<script>alert("Error:Duplicate username");history.go(-1);</script>';
		}

		echo '<script>alert("One record modified"); window.location="admin.php";</script>';
		
	}
	mysql_close($con);


}
else{
	die('Not validated');
}










/*
echo $_POST['username'].' '.
$_POST['password'].' '.
$_POST['userType'].' '.
$_POST['fname'].' '.
$_POST['lname'].' '.
$_POST['payment'].' '.
$_POST['phone1'].' '.
$_POST['phone2'].' '.
$_POST['phone3'].' '.
$_POST['email'];
*/
?>
<?php
function toValidate(){
	$totalB = true;


	$b = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
	$totalB= $totalB && $b;

	$b = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
	$totalB= $totalB && $b;

	$b = filter_var($_POST['userType'],FILTER_SANITIZE_STRING);
	$totalB= $totalB && $b;
	//check type
	
	if($_POST['userType']!='admin' && $_POST['userType']!='employee' && $_POST['userType']!='manager'){
		$totalB = false;
	}

	$b = filter_var($_POST['fname'],FILTER_SANITIZE_STRING);
	$totalB= $totalB && $b;

	$b = filter_var($_POST['lname'],FILTER_SANITIZE_STRING);
	$totalB= $totalB && $b;


	$b = filter_var($_POST['payment'],FILTER_VALIDATE_FLOAT);
	$totalB= $totalB && $b;
	if($_POST['payment']<0){
		$totalB=false;
	}

	return $totalB;
}
?>

</body>
</html>