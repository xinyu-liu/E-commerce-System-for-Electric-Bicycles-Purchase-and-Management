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
<title>Product Category Form</title>
</head>

<body>
<input type="button" value="Category Management Page" onClick="toAdminMainPage()"/>
<body>
<?php
$productCategoryID="";
if(isset($_POST['modify'])){
	$productCategoryID=$_POST['modify'];
}
//////////// for title ////////////////////
if(!$productCategoryID){
	// not exist, it is an add
	echo '<h2>Add a Product Category</h2>';
}
else{
	// it is a modify
	echo '<h2>Modify a Product Category</h2>';
}
?>
<?php
//////// for filled in form ////////////////

if($productCategoryID){
	// modify
	$sql=" select * from ProductCategory where productCategoryID='$productCategoryID' ";
	
	// start DB connection
	$con=mysql_connect('localhost','lxy','1320');
	if(!$con){
		die ('Could not connect to database'.mysql_error() );
	}
	mysql_select_db('company571',$con);
	
	$res = mysql_query($sql); 
	if(  !( $row=mysql_fetch_assoc($res) )  ){
		die ('Invalid productCategoryID');
	}
	// end DB connection
	mysql_close($con);

}

?>


<form name="f1"  method="POST" onsubmit="return toValidate()" action="categoryAddModifyFormSubmit.php">

<input type="hidden" name="productCategoryID" <?php if($productCategoryID){ echo 'value="'.$row['productCategoryID'].'"'; }?> >
<table>
	<tr>
		<th>*Product Category Name:</th>
        <td><input type="text" name="productCategoryName" maxlength="20" <?php if($productCategoryID){ echo 'value="'.$row['productCategoryName'].'"'; }?>></td>
   	</tr>
	<tr>
	<th> Category Description: </th>
        <td><textarea rows="20" cols="40" name="productCategoryDescription"><?php if($productCategoryID){ echo $row['productCategoryDescription']; }?></textarea></td>
   	</tr>
</table>
  
<?php
////////// for submit button ///////////////
echo '<input type="submit" name="categoryAddModifyFormSubmit" value=" ';
if(!$productCategoryID){
	// add
	echo 'Add Product Category';
}
else{
	// modify
	echo 'Modify Product Category';
}
echo '"/></form> ';

?>

<script>

function toValidate(){
	var f = document.f1;
	var totalB = true;
	for(i=0;i<1;i++){
		e = f.productCategoryName;		a="Product Category Name is required!";		b=requiredElem(e,a);
		totalB=totalB&&b;		if(!totalB){break;}
	}
	return totalB;
}
function requiredElem(elemObj,alertText){
	if(elemObj.value==null || elemObj.value.trim() ==""){
		window.alert(alertText);
		return false;
	}
	else{
		return true;
	}
}
function toAdminMainPage(){
	window.location='categoryManagement.php';
}
</script>
</body>
</html>