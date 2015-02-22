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
<title>Manage Special Product</title>
</head>

<body>

    
<?php
$specialProductID="";
if(isset($_POST['specialSaleID'])){
	$specialProductID=$_POST['specialSaleID'];
} 
// Connect to your database software
$con = mysql_connect('localhost','lxy','1320');
// check if connection fails
if(!$con){
	die ('Could not connect to database'.mysql_error() );
}
// Select a database
mysql_select_db('company571',$con);
$productPrice=findProductPrice();
$productID=findProductID();
       
if (toValidate($productID,$productPrice)){	

	if($specialProductID==NULL || $specialProductID==""){
		//add
		
		
		
		$sql="INSERT INTO SpecialSale (productID,specialPrice,startDate,endDate,specialProductDescription) VALUES ('".$productID."','".$_POST['specialProductPrice']."','".$_POST['startDate']."','".$_POST['endDate']."','".$_POST['specialProductDescription']."') ";

		$result=mysql_query($sql,$con);
		if (!$result){
			echo '<script>alert("Error:Duplicate Category Name");history.go(-1);</script>';
		}
		echo '<script>alert("One record added");window.location="specialManagement.php"; </script>';
	}
	else{
		//modify
		$sql=
		"UPDATE SpecialSale SET productID=".$productID.", specialPrice=".$_POST['specialProductPrice'].", startDate='".$_POST['startDate']."', endDate='".$_POST['endDate']."', specialProductDescription='".$_POST['specialProductDescription']."' WHERE specialSaleID='".$specialProductID."';";

		$result=mysql_query($sql,$con);
		if (!$result){
			echo '<script>alert("Error:Duplicate Category Name");history.go(-1);</script>';
		}

		echo '<script>alert("One record modified");window.location="specialManagement.php";</script>';
		
	}
	mysql_close($con);


}
else{
	die('Not validated');
}

?>
<?php

function findProductPrice(){
	$sql2='select productPrice from Product where productName="'.$_POST['specialProductName'].'"';;
	$res2 = mysql_query($sql2);
	$productPrice='';
	while($row2=mysql_fetch_assoc($res2))
	{
		 $productPrice=$row2['productPrice'];
	}
	return $productPrice;
}
function findProductID(){
	$sql2='select productID from Product where productName="'.$_POST['specialProductName'].'"';
	$res2 = mysql_query($sql2);
	$productID="";
	while($row2=mysql_fetch_assoc($res2))
	{
		 $productID=$row2['productID'];
	}
	return $productID;
}
function toValidate($productID,$productPrice){
	$totalB = true;

	if($productID==""){
		$totalB = false;
	}

	$b = filter_var($_POST['specialProductPrice'],FILTER_VALIDATE_FLOAT);
	$totalB= $totalB && $b;

	if($_POST['specialProductPrice']<0 ){
		$totalB=false;
	}	
	if($_POST['specialProductPrice']>=$productPrice){
		echo $_POST['specialProductPrice'].">=".$productPrice."   ";
		echo '<script>alert("Error:Special Sale Price should be lower than Regular Price '.$productPrice.'");history.go(-1);</script>';
		///////////////////////
		$totalB=false;
	}

	$b = filter_var($_POST['startDate'], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^(\d{4})-(\d{2})-(\d{2})$/")));
	$totalB= $totalB && $b;
	
	$b = filter_var($_POST['endDate'], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^(\d{4})-(\d{2})-(\d{2})$/")));
	$totalB= $totalB && $b;

	return $totalB;
}

?>

</body>
</html>