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
<title>Forget Password</title>
</head>

<body>
<?php
//////////// for title ////////////////////
echo '<h2>Forget Password</h2>';
?>

<form name="f1"  method="POST" onsubmit="return toValidate()" action="customerForgetPassword2.php">

<table>
	<tr>
		<th>*username:</th>
        <td><input type="text" name="username" maxlength="20" ></td>
   	</tr>
     <tr>
		<th>*Email: </th>
        <td><input type="text" name="email" onChange="checkEmail()" maxlength="35" /></td>
   	</tr> 
</table>
  
<?php
////////// for submit button ///////////////
echo '<input type="submit" value="Submit"/>';

echo '<input type="button" value="Main Page" onClick="toMainPage()"/></form> ';

?>

<script>
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