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
<title>Manage Product</title>
</head>

<body>

<?php
	// Connect to your database software
	$con= mysql_connect('localhost','lxy','1320');
	// check if connection fails
	if(!$con){
		die ('Could not connect to database'.mysql_error() );
	}
	// Select a database
	mysql_select_db('company571',$con);
	
	// is add or modify
	$productID="";
	if(isset($_POST['productID'])){
		$productID=$_POST['productID'];
	}

/*
if($productID==NULL || $productID==""){
	echo 'add';
}
else{
	echo 'modify';
}
*/
	
if (toValidate()){	
	// find productCategoryID
	$productCategoryID = findProductCategoryID();
	if($productCategoryID==''){
		die('Wrong productCategoryID.');
	}
		
	if($productID==NULL || $productID==""){
		//add		
		$sql="INSERT INTO Product (productName, productCategoryID, productDescription, productImage, productPrice) VALUES ('".$_POST['productName']."','$productCategoryID','".$_POST['productDescription']."','".$_POST['productImage']."','".$_POST['productPrice']."');";
		
		$result = mysql_query($sql);
		if (!$result)
		{
			echo '<script>alert("Error:Duplicate product name");history.go(-1);</script>';
		}
		else
		{
		echo '<script>alert("One record added"); window.location="productManagement.php";</script>';
		}
	}
	else{
		//modify
		
		$sql='UPDATE Product SET productName="'.$_POST['productName'].'",productCategoryID="'.$productCategoryID.'",productDescription="'. $_POST['productDescription'].'",productImage="'.$_POST['productImage'].'",productPrice="'.$_POST['productPrice'].'" WHERE productID="'.$_POST['productID'].'";';
				
		$result=mysql_query($sql,$con);
		if (!$result){
			echo '<script>alert("Error:Duplicate productname");</script>';
		}

		echo '<script>alert("One record modified"); window.location="productManagement.php";</script>';
		
	}


}
else{
	echo '<script>alert("Error:Invalid Form.");history.go(-1);</script>';
}
mysql_close($con);

?>
<?php
function findProductCategoryID(){
	$productCategoryID='';
	$sql2="select * from productCategory";
	$res2 = mysql_query($sql2);
	$b=false;
	while($row2=mysql_fetch_assoc($res2)){
		 if($_POST['productCategory']==$row2['productCategoryName']){
			 $productCategoryID=$row2['productCategoryID'];
			 return $productCategoryID;
		 }
	}
	return $productCategoryID;
}
function toValidate(){
	$totalB = true;

	$b = filter_var($_POST['productName'],FILTER_SANITIZE_STRING);
	$totalB= $totalB && $b;

	$b = filter_var($_POST['productCategory'],FILTER_SANITIZE_STRING);
	$totalB= $totalB && $b;

	//check type
	if(findProductCategoryID()==''){
		$b=false;
	}
	else{
		$b=true;
	}
	$totalB= $totalB && $b;
	//end check type
	
	$b = filter_var($_POST['productPrice'],FILTER_VALIDATE_FLOAT);
	$totalB= $totalB && $b;
	if($_POST['productPrice']<0){
		$totalB=false;
	}

	return $totalB;
}
?>

</body>
</html>