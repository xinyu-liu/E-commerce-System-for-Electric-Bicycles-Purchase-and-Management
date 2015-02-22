<?php 
session_start(); 
require("sessionStart.php");

// start DB connection
require('connectDB.php');
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Customer Form</title>
</head>

<body>
<?php
$customerID="";
if(isset($_SESSION['customerID'])){
	$customerID=$_SESSION['customerID'];
}
// print_r($_SESSION);
//////////// for title ////////////////////
if(!$customerID){
	// not exist, it is an add
	echo '<h2>New Customer Information</h2>';
}
else{
	// it is a modify
	echo '<h2>Modify your Customer Information</h2>';
}
?>
<?php

//////// for filled in form ////////////////
if($customerID){
	// modify
	$sql=" select * from Customer where customerID='$customerID' ";
	
	$res = mysql_query($sql); 
	if(  !( $row=mysql_fetch_assoc($res) )  ){
		die ('Invalid customerID');
	}
	// end DB connection
	mysql_close($con);

}

?>

<form name="f1"  method="POST" onsubmit="return toValidate()" action="customerAddModifyFormSubmit.php">

<input type="hidden" name="customerID" <?php if($customerID){ echo 'value="'.$row['customerID'].'"'; }?> >
<table>
	<tr>
		<th>*username:</th>
        <td><input type="text" name="username" maxlength="20" <?php if($customerID){ echo 'value="'.$row['username'].'"'; }?>></td>
   	</tr>
	<tr>
		<th>*Password:</th>
        <td><input type="password" name="password" maxlength="20"></td>
   	</tr>    
	<tr>
		<th>*First Name:</th>
        <td><input type="text" name="fname" maxlength="20" <?php if($customerID){ echo 'value="'.$row['firstName'].'"'; }?> ></td>
   	</tr>
	<tr>
		<th>*Last Name:</th>
        <td><input type="text" name="lname" maxlength="20" <?php if($customerID){ echo 'value="'.$row['lastName'].'"'; }?> ></td>
   	</tr>  
     <tr>
		<th>*Email: </th>
        <td><input type="text" name="email" onChange="checkEmail()" maxlength="35"  <?php if($customerID){ echo 'value="'.$row['email'].'"'; }?>/></td>
   	</tr>  
      
	<tr>  
		<th>Phone Number:</th>
        <td>	(<input type="text" name="phone1" size="4" maxlength="3" onchange="checkAreaCode()" <?php if($customerID && strlen($row['phone'])>0){ echo 'value="'.substr($row['phone'],0,3) .'"'; }?> />) -
    			<input type="text" name="phone2" size="3" maxlength="3" onchange="checkPhone2()" <?php if($customerID && strlen($row['phone'])>0){ echo 'value="'.substr($row['phone'],4,3) .'"'; }?>/> -
   				 <input type="text" name="phone3" size="5"  maxlength="4" onchange="checkPhone3()" <?php if($customerID && strlen($row['phone'])>0){ echo 'value="'.substr($row['phone'],8,4) .'"'; }?>/></td>
   	</tr>     

</table>
  
<?php
if($customerID){
	// modify	
	echo '<a href="customerDelete.php">Delete your account?</a><br/>';
}

////////// for submit button ///////////////
echo '<input type="submit" name="addModifyCustomerFormSubmit" value=" ';
if(!$customerID){
	// add
	echo 'Submit';
}
else{
	// modify
	echo 'Modify';
}
echo '"/>';

echo '<input type="button" value="Main Page" onClick="toMainPage()"/></form> ';

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
		return false;
	}
	else{
		return true;
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

		e = f.fname;		a="First name is required!";		b=requiredElem(e,a);
		totalB=totalB&&b;		if(!totalB){break;}

		e = f.lname;	a="Last name is required!";		b=requiredElem(e,a);	
		totalB=totalB&&b; 		if(!totalB){break;}
		
		e = f.email;		a="Email is required!";		b=requiredElem(e,a);	
		totalB=totalB&&b; 		if(!totalB){break;}
		if(!checkEmail()){ totalB=false;}
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
function toMainPage(){
	window.location='productView.php';
}
</script>
</body>
</html>