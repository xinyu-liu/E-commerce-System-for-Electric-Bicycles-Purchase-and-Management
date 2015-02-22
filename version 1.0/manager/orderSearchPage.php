<?php 
session_start(); 
error_reporting(E_ALL^E_NOTICE^E_WARNING^E_DEPRECATED);
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

echo '<div style="float:right">';

$pageNum = $_SESSION['pageNum'];

for ($i=0 ; $i<=$pageNum; $i++){
	echo "<a href='orderSearchPage.php?i=".$i."'>".($i*10+1).'-'.($i*10+10).'</a>&nbsp;&nbsp;';
	  
}
echo "<a href='orderSearchForm.php'>Back</a>&nbsp;&nbsp;";
echo '</div>';

// Connect to your database software
$con = mysql_connect('localhost','lxy','1320');
// check if connection fails
if(!$con){
	die ('Could not connect to database'.mysql_error() );
}
// Select a database
mysql_select_db('company571',$con);
if(isset($_GET['i'])){
	$i=$_GET['i'];
}
else{
	$i=0;
}
$sql=$_SESSION['sql'];

$sqlQuantity='select sum(productQuantity) '.substr($sql,9);
$res = mysql_query($sqlQuantity);
if(   $row=mysql_fetch_array($res) ) {
	echo 'Total Quantity: '.$row[0];
}
$sqlPrice='select sum(productTotalPrice) '.substr($sql,9);
$res = mysql_query($sqlPrice);
if(   $row=mysql_fetch_array($res) ) {
	echo '<br/>Total Amount of Sale: '.$row[0];
}
// for display 10 per page
$sql.=' limit '.($i*10).', 10 ';

$res = mysql_query($sql);

echo '<table><tr><th>Product Name</th><th>Product Category</th><th>Unit Price</th><th>Product Quantity</th><th>Total Price</th><th>Order Date</th></tr>';
while(   $row=mysql_fetch_assoc($res) ) {
	echo '<tr><td>'.$row['productName'].'</td><td>'.$row['productCategoryName'].'</td><td>'.$row['productPrice'].'</td><td>'.$row['productQuantity'].'</td><td>'.$row['productTotalPrice'].'</td><td>'.$row['orderDate'].'</td></tr>';
}
echo '</table><br/>';




?>

<?php 
mysql_close($con);	

?>