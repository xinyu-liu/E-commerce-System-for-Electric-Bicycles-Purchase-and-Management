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
<title>Manage Product Categories</title>
</head>

<body>
<h1>MANAGE PRODUCT CATEGORIES INFORMATION</h1>

<input type="button" value="Employee Main Page" onClick="toAdminMainPage()"/>

<h2>Manage Product Category Information</h2>
<form action="categoryAddModifyForm.php" style="display:inline">
	<input type="submit" name="addProduct" value="Add Category"/>
</form>

<form action="categoryModifyDelete.php" method="POST" style="display:inline">
	<input type="submit" name="modifyCategory" value="Modify Category"/>
	<input type="submit" name="deleteCategories" value="Delete Categories"/>
</form>


<br/><br/><br/>
<table>
<tr><th>Product Category Name</th><th>Product Category Description</th></tr>

<?php 
$sql="select * from ProductCategory";

$con = mysql_connect('localhost','lxy','1320');
if(!$con){
	die ('Could not connect to database'.mysql_error() );
}
mysql_select_db('company571',$con);
$res = mysql_query($sql);
	
while(   $row=mysql_fetch_assoc($res) ) {
	echo '<tr><td>'.$row['productCategoryName'].'</td><td>'.$row['productCategoryDescription'].'</td></tr>';

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