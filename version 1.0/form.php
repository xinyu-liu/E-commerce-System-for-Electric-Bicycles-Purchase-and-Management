<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
<form name='f1'>
<table>
	<tr>
		<th>*Username:</th>
        <td><input type="text" maxlength="20"></td>
   	</tr>
	<tr>
		<th>*Password:</th>
        <td><input type="password" maxlength="20"></td>
   	</tr>
	<tr>
		<th>*User Type:</th>
        <td><input type="radio" name="usertype" value="admin">Administrator<br/>
			 <input type="radio" name="usertype" value="employee">Employee<br/>
  			 <input type="radio" name="usertype" value="manager">Manager</td>
   	</tr>    
	<tr>
		<th>*First Name:</th>
        <td><input type="fname" maxlength="20"></td>
   	</tr>
	<tr>
		<th>*Last Name:</th>
        <td><input type="lname" maxlength="20"></td>
   	</tr>    
  	<tr>
		<th>Age:</th>
        <td><input type="text" name="age" maxlength="3"/></td>
   	</tr>
	<tr>
		<th>Phone Number:</th>
        <td>	(<input type="text" name="phone1" size="4" maxlength="3" onchange="checkAreaCode()"/>) -
    			<input type="text" name="phone2" size="3" maxlength="3" onchange="checkPhone2()"/> -
   				 <input type="text" name="phone3" size="5"  maxlength="4" onchange="checkPhone3()"/></td>
   	</tr>     
  	<tr>
		<th>Email: </th>
        <td><input type="text" name="email" onChange="checkEmail()" maxlength="35"/></td>
   	</tr>  
</table>
 <input type="button" value="Save" onclick="toSubmit()" />
</form>      
<script>
function checkAreaCode()
{
	var pattern=/^[1-9]+\d{2}$/;	
	var ph1 = document.f1.phone1;
	var a = ph1.value;
	
	if(a.match(pattern))
	{
		ph1.style.backgroundColor="white";
	}
	else
	{
	 	alert("Please Input a Correct Phone Number");
		ph1.style.backgroundColor="red";
		ph1.value="";
	}
}
function checkPhone2()
{
	var pattern=/^\d{3}$/;	
	var a=document.f1.phone2.value;
	if(a.match(pattern))
	{
		document.f1.phone2.style.backgroundColor="white";
	}
	else
	{
	 	alert("Please Input a Correct Phone Number");
		document.f1.phone2.style.backgroundColor="red";
		document.f1.phone2.value="";
	}
}
function checkPhone3()
{
	var pattern=/^\d{4}$/;	
	var a=document.f1.phone3.value;
	if(a.match(pattern))
	{
		document.f1.phone3.style.backgroundColor="white";
	}
	else
	{
	 	alert("Please Input a Correct Phone Number");
		document.f1.phone3.style.backgroundColor="red";
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
		e.style.backgroundColor = "red";
		window.alert("Invalid Email address. Format: 'a@g.com'. \nPlease re-enter.");
	}
	else{
		e.style.backgroundColor = "white";

	}

}
function toSubmit(){
	if(toValidate()){
	alert("success");
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
		
		e = f.fname;	a="First name is required!";		b=requiredElem(e,a);
		totalB=totalB&&b;		if(!totalB){break;}
	
		e = f.lname;	a="Last name is required!";		b=requiredElem(e,a);	
		totalB=totalB&&b; 		if(!totalB){break;}
			

	}
	return totalB;
}
function requiredElem(elemObj,alertText){
	if(elemObj.value==null || elemObj.value ==""){
		window.alert(alertText);
		e.style.backgroundColor = "red";
		return false;
	}
	else{
		e.style.backgroundColor = "white";
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
</script>
</body>
</html>