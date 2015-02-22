<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.0.js"></script>
<?php
$customerID = $this->session->userdata('customerID');

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
<form name="f1" id="f1" method="post" accept-charset="utf-8" 
            		action=" <?php echo base_url();?>index.php/customer/
<?php echo validation_errors(); ?>
<?php
if(!$customerID){
	// not exist, it is an add
	echo 'add_customer/">';
}
else{
	// it is a modify
	echo 'modify_customer/">';
}
?> 

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
        <td><input type="text" name="email" id="email" maxlength="35"  <?php if($customerID){ echo 'value="'.$row['email'].'"'; }?>/></td>
   	</tr>  
      
	<tr>  
		<th>Phone Number:</th>
        <td>	(<input type="text" name="phone1" id="phone1" size="4" maxlength="3"  <?php if($customerID && strlen($row['phone'])>0){ echo 'value="'.substr($row['phone'],0,3) .'"'; }?> />) -
    			 <input type="text" name="phone2" id="phone2" size="3" maxlength="3"  <?php if($customerID && strlen($row['phone'])>0){ echo 'value="'.substr($row['phone'],4,3) .'"'; }?>/> -
   				 <input type="text" name="phone3" id="phone3" size="5" maxlength="4"  <?php if($customerID && strlen($row['phone'])>0){ echo 'value="'.substr($row['phone'],8,4) .'"'; }?>/></td>
   	</tr>     

</table>
  
<?php
////////// for submit button ///////////////
echo '<input type="submit" value=" ';
if(!$customerID){
	// add
	echo 'Submit';
}
else{
	// modify
	echo 'Modify';
}
echo '"/>';
?>

	<input type="button" id='toMain' value="Main Page" />
</form> 

<script>
$(document).ready(docReady);  

function docReady(){
	$("#phone1").change(checkAreaCode);
	$("#phone2").change(checkPhone2);
	$("#phone3").change(checkPhone3);
	$("#email").change(checkEmail);
	$("#f1").submit(toValidate);
	$('#toMain').click(toMainPage);
}

function checkAreaCode(){
	var pattern=/^[1-9]+\d{2}$/;	
	var a = $("#phone1").val();
	if(!a.match(pattern)){
	 	alert("Please Input a Correct Phone Number");
		$("#phone1").val("");
	}
}
function checkPhone2(){
	var pattern=/^\d{3}$/;	
	var a = $("#phone2").val();
	if(!a.match(pattern)){
	 	alert("Please Input a Correct Phone Number");
		$("#phone2").val("");
	}
}
function checkPhone3(){
	var pattern=/^\d{4}$/;	
	var a = $("#phone3").val();
	if(!a.match(pattern)){
	 	alert("Please Input a Correct Phone Number");
		$("#phone3").val("");
	}
}
function checkEmail(){
	a = $("#email").val();
	var emailPat=/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	var v=a.match(emailPat);
	if(!v){
		window.alert("Invalid Email address. Format: 'a@g.com'. \nPlease re-enter.");
		$("#email").val("");
		return false;
	}
	else{
		return true;
	}
}

function toValidate(){
	var f = document.f1;

	e = f.username;		a="Username is required!";		b=requiredElem(e,a);
	if(!b){return false;}
		
	e = f.password;		a="Password is required!";		b=requiredElem(e,a);	
	if(!b){return false;}

	e = f.fname;		a="First name is required!";	b=requiredElem(e,a);
	if(!b){return false;}

	e = f.lname;	a="Last name is required!";		b=requiredElem(e,a);	
	if(!b){return false;}
		
	e = f.email;		a="Email is required!";		b=requiredElem(e,a);	
	if(!b){return false;}
	if(!checkEmail()){ return false;}

	return true;
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
	window.location="<?php echo base_url(); ?>index.php/product"; 
}
</script>
</body>
</html>