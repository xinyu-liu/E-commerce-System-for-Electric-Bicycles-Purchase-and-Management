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
<title>Manage Specials</title>
</head>

<body>
<input type="button" value="Manage Specials Page" onClick="toAdminMainPage()"/>
<?php
// find out change or delete
$modifySpecialProductButton="";
if(isset($_POST['modifySpecial'])){
	$modifySpecialProductButton = $_POST['modifySpecial'];
}

//////////// for title ////////////////////
if($modifySpecialProductButton){
     // modify
	 echo '<h2>Modify Special Product Selection</h2>';
}
else{
	// delete
	echo '<h2>Delete Special Product Selection</h2>';
}
?>
<?php
// form
if($modifySpecialProductButton){
     // modify
	 echo '<form name="f" method="POST" onsubmit="return isRadioChecked(document.f.modify)" action="specialAddModifyForm.php">';
}
else{
	// delete
	echo '<form name="f" method="POST" onsubmit="return isCheckChecked(document.f.deleteCheckBox)" action="specialDelete.php">';
}

echo '<table>  <tr><th>Product Name</th><th>Regular Price</th><th>Special Price</th><th>Start Date</th><th>End Date</th><th>Special Product Description</th><th>';


if($modifySpecialProductButton){
     // modify
	 echo 'Modify</th></tr>';
}
else{
	// delete
	echo 'Delete</th></tr>';
}


$sql="select * from SpecialSale";

$con = mysql_connect('localhost','lxy','1320');
if(!$con){
	die ('Could not connect to database'.mysql_error() );
}
mysql_select_db('company571',$con);
$res = mysql_query($sql);

while( $row=mysql_fetch_assoc($res) ) {
	$sql2="select productID, productName, productPrice from Product WHERE productID=".$row['productID'].";";
	$res2 = mysql_query($sql2);
	if($row2=mysql_fetch_assoc($res2) ) {
		
		echo '<tr><td>'.$row2['productName'].'</td><td>'.$row2['productPrice'].'</td><td>'.$row['specialPrice'].'</td><td>'.$row['startDate'].'</td><td>'.$row['endDate'].'</td><td>'.$row['specialProductDescription'].'</td><td>';
		///// for Radio button or Check box //////	
		if($modifySpecialProductButton){
    		 // modify
	 		echo '<input type="radio" name="modify" value="'.$row['specialSaleID'].'"/></td></tr>';
		}
		else{
			// delete
			echo '<input type="checkbox" id="deleteCheckBox" name="deleteCheckBox[]" value="'.$row['specialSaleID'].'"/></td></tr>';	
		}
	}
}
echo '</table>';
// At the end of your PHP script
mysql_close($con);

?>
<?php
////////// for submit button ///////////////
if($modifySpecialProductButton){
     // modify
	echo '<input type="submit" name="modifySpecialProductSubmit" value="Modify Special Product"/>';
}
else{
	// delete
	echo '<input type="submit" name="deleteSpecialProductSubmit" value="Delete Special Product"/>';
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
	window.location='specialManagement.php';
}
</script>
</body>
</html>
