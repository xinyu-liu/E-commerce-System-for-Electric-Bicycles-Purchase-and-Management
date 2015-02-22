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
<input type="button" value="Manage Products Page" onClick="toAdminMainPage()"/>
<?php
// find out change or delete
$modifyProductButton="";
if(isset($_POST['modifyProduct'])){
	$modifyProductButton = $_POST['modifyProduct'];
}

//////////// for title ////////////////////
if($modifyProductButton){
     // modify
	 echo '<h2>Modify Product Selection</h2>';
}
else{
	// delete
	echo '<h2>Delete Product Selection</h2>';
}
?>
<?php
// form
if($modifyProductButton){
     // modify
	 echo '<form name="f" method="POST" onsubmit="return isRadioChecked(document.f.modify)" action="productAddModifyForm.php">';
}
else{
	// delete
	echo '<form name="f" method="post" onsubmit="return isCheckChecked(document.f.deleteCheckBox)" action="productDelete.php">';
}

$sql1="SELECT * FROM ProductCategory";

$con = mysql_connect('localhost','lxy','1320');
if(!$con){
	die ('Could not connect to database'.mysql_error() );
}
mysql_select_db('company571',$con);
$res1 = mysql_query($sql1);
echo '<table>';
while(   $row1=mysql_fetch_assoc($res1) ) {
	echo '<tr><th>'.$row1['productCategoryName'].'</th></tr>';
	
	echo '<tr><th>Product Name</th><th>Product Price</th><th>Product Image</th><th>Product Description</th><th>';
	if($modifyProductButton){
    	 // modify
	 	echo 'Modify</th></tr>';
	}
	else{
		// delete
		echo 'Delete</th></tr>';
	}
	
	$sql2='SELECT * FROM Product,ProductCategory WHERE Product.productCategoryID="'.$row1['productCategoryID'].'" AND Product.productCategoryID=ProductCategory.productCategoryID;';
	$res2 = mysql_query($sql2);
	while( $row2=mysql_fetch_assoc($res2) ) {
		echo '<tr><td>'.$row2['productName'].'</td><td>'.$row2['productPrice'].'</td><td>'.$row2['productImage'].'</td><td>'.$row2['productDescription'].'</td><td>';
		
		
		///// for Radio button or Check box //////	
		if($modifyProductButton){
    	 // modify
	 		echo '<input type="radio" name="modify" value="'.$row2['productID'].'"/></td></tr>';
		}
		else{
			// delete
			echo '<input type="checkbox" id="deleteCheckBox" name="deleteCheckBox[]" value="'.$row2['productID'].'"/></td></tr>';
		
		}
	}
	echo '<tr><tr/>';
}	
echo '</table><br/>';
// At the end of your PHP script
mysql_close($con);
?>

<?php
////////// for submit button ///////////////
if($modifyProductButton){
     // modify
	echo '<input type="submit" name="modifyProductSubmit" value="Modify Product"/>';
}
else{
	// delete
	echo '<input type="submit" name="deleteProductSubmit" value="Delete Products"/>';
}

echo ' </form> ';

?>
<script>
function isCheckChecked(radioElem){
	check = false;
	for(i=0;i<radioElem.length;i++){
		if(radioElem[i].checked){
			check= true;
		}
	}
	if(!check){
		window.alert('Please select item(s) that you want to delete.');
	}

	return check;	
}
function isRadioChecked(radioElem){
	check = false;
	for(i=0;i<radioElem.length;i++){
		if(radioElem[i].checked){
			check= true;
		}
	}
	if(!check){
		window.alert('Please select the item that you want to modify.');
	}

	return check;	
}
function toAdminMainPage(){
	window.location='productManagement.php';
}
</script>
</body>
</html>
