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
<title>User Form</title>
</head>

<body>
<?php
$userIndex="";
if(isset($_POST['modify'])){
	$userIndex=$_POST['modify'];
}
//////////// for title ////////////////////
if(!$userIndex){
	// not exist, it is an add
	echo '<h2>Add a User</h2>';
}
else{
	// it is a modify
	echo '<h2>Modify a User</h2>';
}
?>
<?php
//////// for filled in form ////////////////

if($userIndex){
	// modify
	$sql=" select * from Users where userIndex='$userIndex' ";
	
	// start DB connection
	$con=mysql_connect('localhost','lxy','1320');
	if(!$con){
		die ('Could not connect to database'.mysql_error() );
	}
	mysql_select_db('company571',$con);
	
	$res = mysql_query($sql); 
	if(  !( $row=mysql_fetch_assoc($res) )  ){
		die ('Invalid userIndex');
	}
	// end DB connection
	mysql_close($con);

}

?>

<form name="f1"  method="POST" onsubmit="return toValidate()" action="addModifyUserFormSubmit.php">

<input type="hidden" name="userIndex" <?php if($userIndex){ echo 'value="'.$row['userIndex'].'"'; }?> >
<table>
	<tr>
		<th>*Username:</th>
        <td><input type="text" name="username" maxlength="20" <?php if($userIndex){ echo 'value="'.$row['username'].'"'; }?>></td>
   	</tr>
	<tr>
		<th>*Password:</th>
        <td><input type="password" name="password" maxlength="20"></td>
   	</tr>
	<tr>
		<th>*User Type:</th> 
        <td><input type="radio" name="userType" value="admin" <?php if($userIndex && $row['userType']=='admin') {echo ' checked="checked" ';} ?>>Administrator<br/>
			 <input type="radio" name="userType" value="employee" <?php if($userIndex && $row['userType']=='employee') {echo ' checked="checked" ';} ?>>Employee<br/>
  			 <input type="radio" name="userType" value="manager" <?php if($userIndex && $row['userType']=='manager') {echo ' checked="checked" ';} ?>>Manager</td>
   	</tr>    
	<tr>
		<th>*First Name:</th>
        <td><input type="text" name="fname" maxlength="20" <?php if($userIndex){ echo 'value="'.$row['firstName'].'"'; }?> ></td>
   	</tr>
	<tr>
		<th>*Last Name:</th>
        <td><input type="text" name="lname" maxlength="20" <?php if($userIndex){ echo 'value="'.$row['lastName'].'"'; }?> ></td>
   	</tr>    
  	<tr>
		<th>*Payment:</th>
        <td><input type="text" name="payment" maxlength="20" onChange="checkPayment()"  <?php if($userIndex){ echo 'value="'.$row['payment'].'"'; }?>/></td>
   	</tr>
	<tr>  
		<th>Phone Number:</th>
        <td>	(<input type="text" name="phone1" size="4" maxlength="3" onchange="checkAreaCode()" <?php if($userIndex && strlen($row['phone'])>0){ echo 'value="'.substr($row['phone'],0,3) .'"'; }?> />) -
    			<input type="text" name="phone2" size="3" maxlength="3" onchange="checkPhone2()" <?php if($userIndex && strlen($row['phone'])>0){ echo 'value="'.substr($row['phone'],4,3) .'"'; }?>/> -
   				 <input type="text" name="phone3" size="5"  maxlength="4" onchange="checkPhone3()" <?php if($userIndex && strlen($row['phone'])>0){ echo 'value="'.substr($row['phone'],8,4) .'"'; }?>/></td>
   	</tr>     
  	<tr>
		<th>Email: </th>
        <td><input type="text" name="email" onChange="checkEmail()" maxlength="35"  <?php if($userIndex){ echo 'value="'.$row['email'].'"'; }?>/></td>
   	</tr>  
</table>
  
<?php
////////// for submit button ///////////////
echo '<input type="submit" name="addModifyUserFormSubmit" value=" ';
if(!$userIndex){
	// add
	echo 'Add User';
}
else{
	// modify
	echo 'Modify User';
}
echo '"/><input type="button" value="Admin Main Page" onClick="toAdminMainPage()"/></form> ';

?>

<script>

function checkAreaCode()
{
	var pattern=/^[1-9]+\d{2}$/;	
	var ph1 = document.f1.phone1;
	var a = ph1.value;
	
	if(!a.match(pattern)){
	 	alert("Please Input a Correct Phone Number");
		ph1.value="";
	}
}
function checkPhone2()
{
	var pattern=/^\d{3}$/;	
	var a=document.f1.phone2.value;
	if(!a.match(pattern)){
	 	alert("Please Input a Correct Phone Number");
		document.f1.phone2.value="";
	}
}
function checkPhone3()
{
	var pattern=/^\d{4}$/;	
	var a=document.f1.phone3.value;
	if(!a.match(pattern)){
	 	alert("Please Input a Correct Phone Number");
		document.f1.phone3.value="";
	}
}
function checkEmail()
{
	var e=document.f1.email;
	var a= e.value;
	var emailPat=/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	var v=a.match(emailPat);
	if(!v){
		window.alert("Invalid Email address. Format: 'a@g.com'. \nPlease re-enter.");
		document.f1.email.value="";
	}
}
function checkPayment(){
	var pattern=/^(\d*\.)?\d+$/;
	var a = document.f1.payment.value; 
	if(!a.match(pattern))
	{
	 	alert("Please input a valid payment");
		document.f1.payment.value="";
	}
}

function toValidate(){
	var f = document.f1;
	var totalB = true;
	for(i=0;i<1;i++){
		e = f.username;		a="Username is required!";		b=requiredElem(e,a);
		totalB=totalB&&b;		if(!totalB){break;}
		
		e = f.password;		a="Password is required!";		b=requiredElem(e,a);	
		totalB=totalB&&b; 		if(!totalB){break;}
		
		e = f.userType;		b=isRadioChecked(e); 	if (!b){alert("User Type is required!");}
		totalB=totalB&&b; 		if(!totalB){break;}		

		e = f.fname;		a="First name is required!";		b=requiredElem(e,a);
		totalB=totalB&&b;		if(!totalB){break;}

		e = f.lname;	a="Last name is required!";		b=requiredElem(e,a);	
		totalB=totalB&&b; 		if(!totalB){break;}
		
		e = f.payment;		a="Payment is required!";		b=requiredElem(e,a);	
		totalB=totalB&&b; 		if(!totalB){break;}
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
function isRadioChecked(radioElem){

	check = false;
	for(i=0;i<radioElem.length;i++){
		if(radioElem[i].checked){
			check= true;
		}
	}
	return check;	
}
function toAdminMainPage(){
	window.location='admin.php';
}
</script>
</body>
</html>