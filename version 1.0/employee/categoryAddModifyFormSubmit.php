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
<title>Manage Product Category</title>
</head>

<body>
<?php
$productCategoryID="";
if(isset($_POST['productCategoryID'])){
	$productCategoryID=$_POST['productCategoryID'];
}

if (toValidate()){	
	// Connect to your database software
	$con = mysql_connect('localhost','lxy','1320');
	// check if connection fails
	if(!$con){
		die ('Could not connect to database'.mysql_error() );
	}
	// Select a database
	mysql_select_db('company571',$con);
	
	if($productCategoryID==NULL || $productCategoryID==""){
		//add
		$sql="INSERT INTO ProductCategory (productCategoryName,productCategoryDescription) VALUES ('".$_POST['productCategoryName']."','".$_POST['productCategoryDescription']."') ";
		$result=mysql_query($sql,$con);
		if (!$result){
			echo '<script>alert("Error:Duplicate Category Name");history.go(-1);</script>';
		}
		echo '<script>alert("One record added"); window.location="categoryManagement.php";</script>';
	}
	else{
		//modify
		$sql="UPDATE ProductCategory SET productCategoryName='".$_POST['productCategoryName']."',productCategoryDescription='".$_POST['productCategoryDescription']."' WHERE productCategoryID='".$productCategoryID."';";
		$result=mysql_query($sql,$con);
		if (!$result){
			echo '<script>alert("Error:Duplicate Category Name");history.go(-1);</script>';
		}

		echo '<script>alert("One record modified"); window.location="categoryManagement.php";</script>';
		
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
	$b = filter_var($_POST['productCategoryName'],FILTER_SANITIZE_STRING);
	$totalB= $totalB && $b;

	return $totalB;
}
?>

</body>
</html>