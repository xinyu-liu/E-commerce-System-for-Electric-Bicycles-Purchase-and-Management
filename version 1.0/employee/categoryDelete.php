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
<title>Untitled Document</title>
</head>

<body>
<body>
<?php
$con = mysql_connect('localhost','lxy','1320');
if(!$con){
	die ('Could not connect to database'.mysql_error() );
}
mysql_select_db('company571',$con);


$checkbox = $_POST['deleteCheckBox']; 
// delete items in Category table
foreach($checkbox as $productCategoryID){
	$sql='DELETE FROM ProductCategory WHERE productCategoryID='.$productCategoryID.';';
	if (!mysql_query($sql,$con)){
			die('Error: ' . mysql_error());
	}
}
// delete items in SpecialSale table
foreach($checkbox as $productCategoryID){
	$sql_find='SELECT productID FROM Product WHERE productCategoryID='.$productCategoryID.';';

	$res = mysql_query($sql_find); 
	while( $row=mysql_fetch_assoc($res) ){
		$sql2='DELETE FROM SpecialSale WHERE productID='.$row['productID'].';';

		if (!mysql_query($sql2,$con)){
				die('Error: ' . mysql_error());
		}
	}
}
// delete items in Product table
foreach($checkbox as $productCategoryID){
	
	$sql='DELETE FROM Product WHERE productCategoryID='.$productCategoryID.';';
	if (!mysql_query($sql,$con)){
			die('Error: ' . mysql_error());
	}
}

echo '<script>alert("Product category record(s) deleted"); window.location="categoryManagement.php";</script>';
mysql_close($con);

?>
</body>
</html>
