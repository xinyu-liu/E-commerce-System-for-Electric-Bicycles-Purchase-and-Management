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
<?
error_reporting(E_ALL^E_NOTICE^E_WARNING^E_DEPRECATED);
$productName = $_POST["productName"];
$productCategory='';
if(isset($_POST["productCategory"])){
	$productCategory = $_POST["productCategory"];
}
$isSpecial = '';
if(isset($_POST["isSpecial"])){
	$isSpecial = $_POST["isSpecial"];
}
$startDate = $_POST["startDate"];
$endDate = $_POST["endDate"];

// Connect to your database software
$con = mysql_connect('localhost','lxy','1320');
// check if connection fails
if(!$con){
	die ('Could not connect to database'.mysql_error() );
}
// Select a database
mysql_select_db('company571',$con);

$sql='select * from Product AS p, ProductCategory AS pc, Orders AS o, OrderDetail AS od ';


$sql.= 'where pc.productCategoryID=p.productCategoryID 
	   		AND od.productID=p.productID 
	   		AND o.orderID=od.orderID';

$where='';
if($productName!='') {
	if ( strpos($productName,'%') ==false && strpos($productName,'_') ==false ){
		$where=$where.' and productName ="'.$productName.'"';
	}
	else{	
		$where=$where.' and productName like"'.$productName.'"';
	}
}

if($productCategory!='' && $productCategory!='All') {
	$where=$where.' and productCategoryName="'.$productCategory.'"';
}
if($isSpecial=='Y'){
	$where=$where.' and isSpecial=1';
}
elseif($isSpecial=='N'){
	$where=$where.' and isSpecial=0';
}
if($startDate!='') {
	$where=$where.' and orderDate>="'.$startDate.'"';
}
if($endDate!='') {
	$where=$where.' and orderDate<="'.$endDate.'"';
}

$sql.=$where;
$res = mysql_query($sql);
$totalNum = mysql_num_rows($res);
$pageNum = floor ($totalNum/10);

$_SESSION['sql']=$sql;
$_SESSION['pageNum'] = $pageNum;

mysql_close($con);	

/*
// for display all
echo '<table><tr><th>Product Name</th><th>Product Category</th><th>Unit Price</th><th>Product Quantity</th><th>Total Price</th><th>Order Date</th></tr>';


while(   $row=mysql_fetch_assoc($res) ) {
	echo '<tr><td>'.$row['productName'].'</td><td>'.$row['productCategoryName'].'</td><td>'.$row['productPrice'].'</td><td>'.$row['productQuantity'].'</td><td>'.$row['productTotalPrice'].'</td><td>'.$row['orderDate'].'</td></tr>';
}
echo '</table><br/>';

*/
require('orderSearchPage.php');



?>
