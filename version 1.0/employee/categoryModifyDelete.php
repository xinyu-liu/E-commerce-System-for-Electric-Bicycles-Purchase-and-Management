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
<input type="button" value="Manage Category Page" onClick="toAdminMainPage()"/>
<?php
// find out change or delete
$modifyProductCategoryButton="";
if(isset($_POST['modifyCategory'])){
	$modifyProductCategoryButton = $_POST['modifyCategory'];
}

//////////// for title ////////////////////
if($modifyProductCategoryButton){
     // modify
	 echo '<h2>Modify Product Category Selection</h2>';
}
else{
	// delete
	echo '<h2>Delete Product Category Selection</h2>';
}
?>
<?php
// form
if($modifyProductCategoryButton){
     // modify
	 echo '<form name="f" method="POST" onsubmit="return isRadioChecked(document.f.modify)" action="categoryAddModifyForm.php">';
}
else{
	// delete
	echo '<form name="f" method="post" onsubmit="return isCheckChecked(document.f.deleteCheckBox)" action="categoryDelete.php">';
}

echo '<table><tr><th>Product Category Name</th><th>Product Category Description</th><th>';
if($modifyProductCategoryButton){
     // modify
	 echo 'Modify</th></tr>';
}
else{
	// delete
	echo 'Delete</th></tr>';
}


$sql="select * from ProductCategory";

$con = mysql_connect('localhost','lxy','1320');
if(!$con){
	die ('Could not connect to database'.mysql_error() );
}
mysql_select_db('company571',$con);
$res = mysql_query($sql);

while(   $row=mysql_fetch_assoc($res) ) {
	echo '<tr><td>'.$row['productCategoryName'].'</td><td>'.$row['productCategoryDescription'].'</td><td>';
	
	///// for Radio button or Check box //////	
	if($modifyProductCategoryButton){
     // modify
	 	echo '<input type="radio" name="modify" value="'.$row['productCategoryID'].'"/></td></tr>';
	}
	else{
		// delete
		echo '<input type="checkbox" id="deleteCheckBox" name="deleteCheckBox[]" value="'.$row['productCategoryID'].'"/></td></tr>';
		
	}
}
echo '</table>';
// At the end of your PHP script
mysql_close($con);
?>
<?php
////////// for submit button ///////////////
if($modifyProductCategoryButton){
     // modify
	echo '<input type="submit" name="modifyProductCategorySubmit" value="Modify Product Category"/>';
}
else{
	// delete
	echo '<input type="submit" name="deleteProductCategorySubmit" value="Delete Product Category"/>';
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
	window.location='categoryManagement.php';
}
</script>
</body>
</html>
