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


<?php

$productName = $_POST["productName"];
$minPrice = $_POST["minPrice"];
$maxPrice = $_POST["maxPrice"];
$productCategory = $_POST["productCategory"];

// Connect to your database software
$con = mysql_connect('localhost','lxy','1320');
// check if connection fails
if(!$con){
	die ('Could not connect to database'.mysql_error() );
}
// Select a database
mysql_select_db('company571',$con);

$sql='select * from Product,ProductCategory where ProductCategory.productCategoryID=Product.productCategoryID';
$where='';
if($productName!='') {
	if ( strpos($productName,'%') ==false && strpos($productName,'_') ==false ){
		$where=$where.' and productName ="'.$productName.'"';
	}
	else{	
		$where=$where.' and productName like"'.$productName.'"';
	}
}
if($minPrice!='') {
	$where=$where.' and productPrice>="'.$minPrice.'"';
}
if($maxPrice!='') {
	$where=$where.' and productPrice<="'.$maxPrice.'"';
}
if($productCategory!='') {
	$where=$where.' and productCategoryName="'.$productCategory.'"';
}

$sql.=$where;

$res = mysql_query($sql);
echo '<table><tr><th>Product Name</th><th>Product Category</th><th>Product Price</th><th>Product Image</th><th>Product Description</th></tr>';

while(   $row=mysql_fetch_assoc($res) ) {
	echo '<tr><td>'.$row['productName'].'</td><td>'.$row['productCategoryName'].'</td><td>'.$row['productPrice'].'</td><td>'.$row['productImage'].'</td><td>'.$row['productDescription'].'</td></tr>';
}
echo '</table><br/>';

mysql_close($con);	

?>