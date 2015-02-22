<?php 
session_start(); 

if ($_SESSION['username']==null || $_SESSION['username']==''){
	session_destroy();
	echo '<script>window.alert("You have not logged in. Please re-login.");</script>';
	echo "<script>window.location='/hw2/login.php';</script>";
}
if($_SESSION['userType']!='admin'){
	session_destroy();
	echo '<script>window.alert("You have no permission of admin. Please re-login.");</script>';
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
<title>Manage User</title>
</head>

<body>
<?php
// find out change or delete
$modifyUserButton="";
if(isset($_POST['modifyUser'])){
	$modifyUserButton = $_POST['modifyUser'];
}

//////////// for title ////////////////////
if($modifyUserButton){
     // modify
	 echo '<h2>Modify User Selection</h2>';
}
else{
	// delete
	echo '<h2>Delete User Selection</h2>';
}
?>
<?php
// form
if($modifyUserButton){
     // modify
	 echo '<form name="f" method="POST" onsubmit="return isRadioChecked(document.f.modify)" action="addModifyUserForm.php">';
}
else{
	// delete
	echo '<form name="f" method="post" onsubmit="return isCheckChecked(document.f.deleteCheckBox)" action="deleteUsers.php">';
}

echo '<table><tr><th>Username</th><th>User Type</th><th>First Name</th><th>Last Name</th><th>Payment</th><th>Phone Number</th><th>Email</th><th>';
if($modifyUserButton){
     // modify
	 echo 'Modify</th></tr>';
}
else{
	// delete
	echo 'Delete</th></tr>';
}


$sql="select * from Users";

$con = mysql_connect('localhost','lxy','1320');
if(!$con){
	die ('Could not connect to database'.mysql_error() );
}
mysql_select_db('company571',$con);
$res = mysql_query($sql);
	
while(   $row=mysql_fetch_assoc($res) ) {
	echo '<tr><td>'.$row['username'].'</td><td>'.$row['userType'].'</td><td>'.$row['firstName'].'</td><td>'.$row['lastName'].'</td><td>'.$row['payment'].'</td><td>'.$row['phone'].'</td><td>'.$row['email'].'</td><td>';
	
	///// for Radio button or Check box //////	
	if($modifyUserButton){
     // modify
	 	echo '<input type="radio" name="modify" value="'.$row['userIndex'].'"/></td></tr>';
	}
	else{
		// delete
		echo '<input type="checkbox" id="deleteCheckBox" name="deleteCheckBox[]" value="'.$row['userIndex'].'"/></td></tr>';
		
	}
}
echo '</table>';
// At the end of your PHP script
mysql_close($con);
?>
<?php
////////// for submit button ///////////////
if($modifyUserButton){
     // modify
	echo '<input type="submit" name="modifyUserSubmit" value="Modify User"/>';
}
else{
	// delete
	echo '<input type="submit" name="deleteUserSubmit" value="Delete Users"/>';
}
echo '<input type="button" value="Back to Admin Main Page" onClick="toAdminMainPage()"/>';
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
	window.location='admin.php';
}
</script>
</body>
</html>
