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
<title>Manage Special Products</title>
</head>

<body>
<h1>MANAGE SPECIAL PRODUCTS INFORMATION</h1>

<input type="button" value="Employee Main Page" onClick="toAdminMainPage()"/>

<h2>Manage Special Product Information</h2>
<form action="specialAddModifyForm.php" style="display:inline">
	<input type="submit" name="addSpecial" value="Add Special"/>
</form>

<form action="specialModifyDelete.php" method="POST" style="display:inline">
	<input type="submit" name="modifySpecial" value="Modify Special"/>
	<input type="submit" name="deleteSpecials" value="Delete Specials"/>
</form>


<br/><br/><br/>
<table>
<tr><th>Product Name</th><th>Regular Price</th><th>Special Price</th><th>Start Date</th><th>End Date</th><th>Special Product Description</th></tr>

<?php 
$con = mysql_connect('localhost','lxy','1320');
if(!$con){
	die ('Could not connect to database'.mysql_error() );
}
mysql_select_db('company571',$con);

$sql="select * from SpecialSale";
$res = mysql_query($sql);
while( $row=mysql_fetch_assoc($res) ) {
	$sql2="select productID, productName, productPrice from Product WHERE productID=".$row['productID'].";";
	$res2 = mysql_query($sql2);
	if($row2=mysql_fetch_assoc($res2) ) {
		
	echo '<tr><td>'.$row2['productName'].'</td><td>'.$row2['productPrice'].'</td><td>'.$row['specialPrice'].'</td><td>'.$row['startDate'].'</td><td>'.$row['endDate'].'</td><td>'.$row['specialProductDescription'].'</td></tr>';
	}
}
echo '</table>';
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