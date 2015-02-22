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
<title>Manage Products</title>
</head>

<body>
<h1>MANAGE PRODUCTS INFORMATION</h1>

<input type="button" value="Employee Main Page" onClick="toAdminMainPage()"/>

<h2>Manage Product Information</h2>
<form action="productAddModifyForm.php" style="display:inline">
	<input type="submit" name="addProduct" value="Add Product"/>
</form>

<form action="productModifyDelete.php" method="POST" style="display:inline">
	<input type="submit" name="modifyProduct" value="Modify Product"/>
	<input type="submit" name="deleteProducts" value="Delete Products"/>
</form>

<br/><br/><br/>


<?php 
$sql1="SELECT * FROM ProductCategory";

$con = mysql_connect('localhost','lxy','1320');
if(!$con){
	die ('Could not connect to database'.mysql_error() );
}
mysql_select_db('company571',$con);
$res1 = mysql_query($sql1);
	
while(   $row1=mysql_fetch_assoc($res1) ) {
	echo '<table><tr><th>'.$row1['productCategoryName'].'</th></tr>';
	
	echo '<tr><th>Product Name</th><th>Product Price</th><th>Product Image</th><th>Product Description</th></tr>';
		
	$sql2='SELECT * FROM Product,ProductCategory WHERE Product.productCategoryID="'.$row1['productCategoryID'].'" AND Product.productCategoryID=ProductCategory.productCategoryID;';
	$res2 = mysql_query($sql2);
	while( $row2=mysql_fetch_assoc($res2) ) {
		echo '<tr><td>'.$row2['productName'].'</td><td>'.$row2['productPrice'].'</td><td>'.$row2['productImage'].'</td><td>'.$row2['productDescription'].'</td></tr>';
	}
	echo '</table><br/>';
}


// At the end of your PHP script
mysql_close($con);
?>
<script>
function toAdminMainPage(){
	window.location='employee.php';
}
</script>




</body>
</html>