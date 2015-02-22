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

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Product Search</title>
<script src="manager.js"></script>
</head>

<body>
<h2>Product Search and View</h2>
<form id="pform" name="f">
<input type="button" value="Manager Main Page" onClick="toAdminMainPage()"/>
<table>
	<tr>
		<th>Product Name: </th>
        <td><input type="text" name="productName" maxlength="20"/></td>
        <td>NOTE: <br/>   % is a substitute for zero or more characters <br/>
							_ is a	substitute for a single character</td>         
   	</tr>
	<tr>
		<th>Price From: </th>
        <td><input type="text" name="minPrice" maxlength="20" onChange="checkMinPrice()"/></td>
   	</tr>
	<tr>
		<th>Price To: </th>
        <td><input type="text" name="maxPrice" maxlength="20" onChange="checkMaxPrice()" /></td>
   	</tr>
    <tr>
		<th>Product Category: </th>
<td>
<?php
$con=mysql_connect('localhost','lxy','1320');
if(!$con){
	die ('Could not connect to database'.mysql_error() );
}
mysql_select_db('company571',$con);
//////// for radio button value ////////////////
$sql2="select productCategoryName from productCategory";
$res2=mysql_query($sql2);
	
while($row2=mysql_fetch_array($res2)){
	echo  '<input type="radio" name="productCategory" value="'. $row2[0]. '" >'.  $row2[0].'</input><br/>'; 
}
?>
        </td> 
   	</tr>  
    <tr><td><input type="button" value="Search" onClick="showProduct()"></td></tr>
</table>

</form>
<br/><br/><br/><br/>
<div id="result"><b>Product Search Result will be shown here.</b></div>
<script>
function checkMinPrice()
{
	var pattern=/^(\d*\.)?\d+$/;
	var a = document.f.minPrice.value; 
	if(a!="" && !a.match(pattern))
	{
	 	alert("Please input a valid price");
		document.f.minPrice.value="";
	}
	if(document.f.maxPrice.value!="" && document.f.minPrice.value>document.f.maxPrice.value){
	 	alert("The min price should be smaller than or equal to the max price.");
		document.f.minPrice.value="";
	}
}
function checkMaxPrice()
{
	var pattern=/^(\d*\.)?\d+$/;
	var a = document.f.maxPrice.value; 
	if(a!="" && !a.match(pattern)){
	 	alert("Please input a valid price");
		document.f.maxPrice.value="";
	}
	if(document.f.minPrice.value!="" && document.f.minPrice.value>document.f.maxPrice.value){
	 	alert("The max price should be larger than or equal to the min price.");
		document.f.maxPrice.value="";
	}
}
</script>
<script>
function toAdminMainPage(){
	window.location='manager.php';
}
</script>
</body>

</html>