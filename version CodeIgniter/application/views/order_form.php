
<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.0.js"></script>
<form name="f1"  method="POST" 
	  action = "<?php echo base_url();?>index.php/order/order_form_info">
<?php echo validation_errors(); ?>

<table>
	<tr>
		<th colspan="2">Shipping Information:</th>
   	</tr>  
	<tr>
		<th>*Name:</th>
        <td><input type="text" name="shippingName" maxlength="30" ></td>
   	</tr>  
	<tr>
		<th>*Road Addr:</th>
        <td><input type="text" name="shippingRoad" maxlength="100" ></td>
   	</tr> 
	<tr>
		<th>*City,&nbsp;State:</th>
        <td><input type="text" name="shippingCity" maxlength="20" size= "13">, &nbsp;
        	 <input type="text" name="shippingState" maxlength="2" size="3" style="text-transform:uppercase;"></td>
   	</tr>  
	<tr>  
		<th>*Phone Number:</th>
        <td>	(<input type="text" name="shippingPhone1" size="4" maxlength="3" onchange="checkAreaCode()" />) -
    			 <input type="text" name="shippingPhone2" size="3" maxlength="3" onchange="checkPhone2()" /> -
   				 <input type="text" name="shippingPhone3" size="5"  maxlength="4" onchange="checkPhone3()" /></td>
   	</tr>

<tr> <td> <br /> </td></tr>

	<tr>
		<th colspan="2">Payment: </th>
   	</tr>  
    <tr>  
		<th>*Credit Card Number:</th>
        <td>	<input type="text" name="creditCardNumber1" size="5" maxlength="4" onchange="checkCreditNumber(1)" /> -
    			<input type="text" name="creditCardNumber2" size="5" maxlength="4" onchange="checkCreditNumber(2)" /> -
   				<input type="text" name="creditCardNumber3" size="5"  maxlength="4" onchange="checkCreditNumber(3)" /> -
              <input type="text" name="creditCardNumber4" size="5"  maxlength="4" onchange="checkCreditNumber(4)" /> 
        </td>
   	</tr>
	<tr>
		<th>*Credit Card Pin <br/>(3 digits):</th>
        <td><input type="text" name="creditCardPin" size="5"  maxlength="3" onchange="checkCreditPin()"></td>
   	</tr>  
    
        
<tr> <td> <br /> </td></tr>
    
    
	<tr>
		<th colspan="2">Billing Information:</th>
   	</tr>  
	<tr>
		<th>*Name:</th>
        <td><input type="text" name="billingName" maxlength="30" ></td>
   	</tr>  
	<tr>
		<th>*Road Addr:</th>
        <td><input type="text" name="billingRoad" maxlength="100" ></td>
   	</tr> 
	<tr>
		<th>*City,&nbsp;State:</th>
        <td><input type="text" name="billingCity" maxlength="20" size= "13">, &nbsp;
        	 <input type="text" name="billingState" maxlength="2" size="3" onChange="checkState2()" style="text-transform:uppercase;"></td>
   	</tr>         
</table>
<input type="submit" name="finish" value="Finish and Pay"/>

<script>
function checkState()
{
	/*
	var pattern=/^[A-Z]{2}$/;	
	var a=document.f1.shippingState.value;
	if(!a.match(pattern)){
	 	alert("Please Input a Correct State for Shipping");
		document.f1.shippingState.value="";
		return false;
	}
	return true;
	*/
}
function checkState2()
{
	/*
	var pattern=/^[A-Z]{2}$/;	
	var a=document.f1.billingState.value;
	if(!a.match(pattern)){
	 	alert("Please Input a Correct State for Billing");
		document.f1.billingState.value="";
		return false;
	}
	return true;
	*/
}
function checkAreaCode()
{
	var pattern=/^[1-9]+\d{2}$/;	
	var ph1 = document.f1.shippingPhone1;
	var a = ph1.value;
	
	if(!a.match(pattern)){
	 	alert("Please Input a Correct Phone Number");
		ph1.value="";
		return false;
	}
	return true;
}
function checkPhone2()
{
	var pattern=/^\d{3}$/;	
	var a=document.f1.shippingPhone2.value;
	if(!a.match(pattern)){
	 	alert("Please Input a Correct Phone Number");
		document.f1.shippingPhone2.value="";
		return false;
	}
	return true;
}
function checkPhone3()
{
	var pattern=/^\d{4}$/;	
	var a=document.f1.shippingPhone3.value;
	if(!a.match(pattern)){
	 	alert("Please Input a Correct Phone Number");
		document.f1.shippingPhone3.value="";
		return false;
	}
	return true;
}
function checkCreditNumber(index)
{
	var pattern=/^\d{4}$/;	
	if(index==1){
		a=document.f1.creditCardNumber1.value;
		if(!a.match(pattern)){
	 		alert("Please Input a Correct Credit Card Number");
			document.f1.creditCardNumber1.value="";
			return false;
		}
		return true;
	}
	else if(index==2){
		a=document.f1.creditCardNumber2.value;
		if(!a.match(pattern)){
	 		alert("Please Input a Correct Credit Card Number");
			document.f1.creditCardNumber2.value="";
			return false;
		}
		return true;
	}	
	else if(index==3){
		a=document.f1.creditCardNumber3.value;
		if(!a.match(pattern)){
	 		alert("Please Input a Correct Credit Card Number");
			document.f1.creditCardNumber3.value="";
			return false;
		}
		return true;
	}
	else if(index==4){
		a=document.f1.creditCardNumber4.value;
		if(!a.match(pattern)){
	 		alert("Please Input a Correct Credit Card Number");
			document.f1.creditCardNumber4.value="";
			return false;
		}
		return true;
	}
}
function checkCreditPin()
{
	var pattern=/^\d{3}$/;	
	var a=document.f1.creditCardPin.value;
	if(!a.match(pattern)){
	 	alert("Please Input a Correct Credit Card Pin");
		document.f1.creditCardPin.value="";
		return false;
	}
	return true;
}


function toValidate(){
	var f = document.f1;
	var totalB = true;
	for(i=0;i<1;i++){
		e = f.shippingName;	a="Name for Shipping is required!";		b=requiredElem(e,a);
		totalB=totalB&&b;		if(!totalB){break;}
		
		e = f.shippingRoad;	a="Road Address for Shipping is required!";		b=requiredElem(e,a);	
		totalB=totalB&&b; 		if(!totalB){break;}
		
		e = f.shippingCity;	a="City for Shipping is required!";		b=requiredElem(e,a);
		totalB=totalB&&b;		if(!totalB){break;}

		e = f.shippingState;	a="State for Shipping is required!";		b=requiredElem(e,a);	
		totalB=totalB&&b; 		if(!totalB){break;}
		if(!checkState()){break;}		
		
		e = f.shippingPhone1;	a="Phone number is required!";		b=requiredElem(e,a);
		totalB=totalB&&b; 		if(!totalB){break;}
		e = f.shippingPhone2;	a="Phone number is required!";		b=requiredElem(e,a);	
		totalB=totalB&&b; 		if(!totalB){break;}	
		e = f.shippingPhone3;	a="Phone number is required!";		b=requiredElem(e,a);	
		totalB=totalB&&b; 		if(!totalB){break;}
		if(!checkAreaCode()){break;}
		if(!checkPhone2){break;}
		if(!checkPhone3){break;}
	
		e = f.creditCardNumber1;	a="Credit Card Number is required!";		b=requiredElem(e,a);
		totalB=totalB&&b; 		if(!totalB){break;}	
		e = f.creditCardNumber2;	a="Credit Card Number is required!";		b=requiredElem(e,a);	
		totalB=totalB&&b; 		if(!totalB){break;}		
		e = f.creditCardNumber3;	a="Credit Card Number is required!";		b=requiredElem(e,a);	
		totalB=totalB&&b; 		if(!totalB){break;}		
		e = f.creditCardNumber4;	a="Credit Card Number is required!";		b=requiredElem(e,a);	
		totalB=totalB&&b; 		if(!totalB){break;}
		if(!checkCreditNumber(1)){break;}
		if(!checkCreditNumber(2)){break;}
		if(!checkCreditNumber(3)){break;}
		if(!checkCreditNumber(4)){break;}
		
		e = f.creditCardPin;	a="Credit Card Pin is required!";		b=requiredElem(e,a);	
		totalB=totalB&&b; 		if(!totalB){break;}
		if(!checkCreditPin()){break;}
		
		e = f.billingName;		a="Name for Billing is required!";		b=requiredElem(e,a);
		totalB=totalB&&b;		if(!totalB){break;}
		
		e = f.billingRoad;		a="Road Address for Billing is required!";		b=requiredElem(e,a);	
		totalB=totalB&&b; 		if(!totalB){break;}
		
		e = f.billingCity;		a="City for Billing is required!";		b=requiredElem(e,a);
		totalB=totalB&&b;		if(!totalB){break;}

		e = f.billingState;	a="State for Billing is required!";		b=requiredElem(e,a);	
		totalB=totalB&&b; 		if(!totalB){break;}
		if(!checkState2()){break;}		
		
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