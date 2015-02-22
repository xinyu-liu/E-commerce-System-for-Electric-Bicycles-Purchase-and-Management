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
<title>Special Product Form</title>
</head>

<body>
<input type="button" value="Special Management Page" onClick="toAdminMainPage()"/>
<body>
<?php
$specialProductID="";
if(isset($_POST['modify'])){
	$specialProductID=$_POST['modify'];
}
//////////// for title ////////////////////
if(!$specialProductID){
	// not exist, it is an add
	echo '<h2>Add a Special Product</h2>';
}
else{
	// it is a modify
	echo '<h2>Modify a Special Product</h2>';
}
?>
<?php
//////// for filled in form ////////////////

if($specialProductID){
	// modify
	// start DB connection
	$con=mysql_connect('localhost','lxy','1320');
	if(!$con){
		die ('Could not connect to database'.mysql_error() );
	}
	mysql_select_db('company571',$con);
	
	$sql=" select * from SpecialSale where specialSaleID='$specialProductID' ";
	$res = mysql_query($sql); 
	if(  !( $row=mysql_fetch_assoc($res) )  ){
		die ('Invalid specialProductID');
	}
	$sql2="select productID, productName, productPrice from Product WHERE productID=".$row['productID'].";";
	$res2 = mysql_query($sql2);
	if( !($row2=mysql_fetch_assoc($res2)) ) {
		die ('Invalid productID');
	}
	// end DB connection
	mysql_close($con);
}
?>

<form name="f4"  method="POST" onsubmit="return toValidate()" action="specialAddModifyFormSubmit.php">

<input type="hidden" name="specialSaleID" <?php if($specialProductID){ echo 'value="'.$row['specialSaleID'].'"'; }?> >
<table>
	<tr>
		<th>*Special Product Name:</th>
        <td><input type="text" name="specialProductName" maxlength="20" <?php if($specialProductID){ echo 'value="'.$row2['productName'].'"'; }?>></td>
   	</tr>
    <tr>
		<th>*Special Product Price</th>
        <td><input type="text" maxlength="20" name="specialProductPrice" onChange="checkPrice()" <?php if($specialProductID){ echo 'value="'.$row['specialPrice'].'"'; }?>/></td>
   	</tr> 
    	<tr>
		<th>*Start Date (YYYY-MM-DD)</th>
        <td>
        	<input type="text" maxlength="10" name="startDate" onChange="checkDateStart()" <?php if($specialProductID){ echo 'value="'.$row['startDate'].'"'; }?>/>
        </td>
   	</tr>
	<tr>
		<th>*End Date (YYYY-MM-DD)</th>
        <td>
        	<input type="text" maxlength="10" name="endDate" onChange="checkDateEnd()" <?php if($specialProductID){ echo 'value="'.$row['endDate'].'"'; }?>/>
        </td>
   	</tr>
    
	<tr>
	<th> Category Description: </th>
        <td><textarea rows="20" cols="40" name="specialProductDescription"><?php if($specialProductID){ echo $row['specialProductDescription']; }?></textarea></td>
   	</tr>
</table>
  
<?php
////////// for submit button ///////////////
echo '<input type="submit" name="categoryAddModifyFormSubmit" value=" ';
if(!$specialProductID){
	// add
	echo 'Add Special Product';
}
else{
	// modify
	echo 'Modify Special Product';
}
echo '"/></form> ';

?>

<script>

function checkPrice()
{
	var pattern=/^(\d*\.)?\d+$/;
	var a = document.f4.specialProductPrice.value; 
	if(!a.match(pattern))
	{
	 	alert("Please input a valid price");
		document.f2.productPrice.value="";
	}
}

var d=new Date();
function checkDateStart()
{
	var a=document.f4.startDate.value;
	var pattern=/^(\d{4})-(\d{2})-(\d{2})$/;
	var valid=a.match(pattern);
	var b=Date.parse(a);
	d=new Date(a);// start date
	if(valid)
	{
		if(isNaN(b))
		{
			alert("Please input a valid date");
			document.f4.startDate.value="";
		}
	}
	else
	{	
		alert("Please follow date format");
		document.f4.startDate.value="";
	}
}
function checkDateEnd()
{
	var a=document.f4.endDate.value;
	var pattern=/^(\d{4})-(\d{2})-(\d{2})$/;
	var valid=a.match(pattern);
	var b=Date.parse(a);
	var e=new Date(a); //end date
	var cur=new Date();
	if(valid)
	{
		if(isNaN(b) || e<d || e<cur)
		{
			alert("Please input a valid date");
			document.f4.endDate.value="";
			return;
		}
		return true;
	}
	else
	{	
		alert("Please follow date format");
		document.f4.endDate.value="";
		return;
	}
}
function toSubmit(){
	if(toValidate()){
	alert("success");
	}
}
function toValidate(){
	var f = document.f4;
	var totalB = true;
	for(i=0;i<1;i++){
		e = f.specialProductName;		a="Special product name is required!";		b=requiredElem(e,a);
		totalB=totalB&&b;		if(!totalB){break;}	
		e = f.specialProductPrice;		a="Special product price is required!";		b=requiredElem(e,a);	
		totalB=totalB&&b; 		if(!totalB){break;}
		e = f.startDate;		a="Special product start date is required!";		b=requiredElem(e,a);	
		totalB=totalB&&b; 		if(!totalB){break;}
		e = f.endDate;		a="Special product end date is required!";		b=requiredElem(e,a);	
		totalB=totalB&&b; 		if(!totalB){break;}
	}
	return totalB;
}
function requiredElem(elemObj,alertText)
{
	if(elemObj.value==null || elemObj.value ==""){
		alert(alertText);
		return false;
	}
	else{
		return true;
	}
}

function toAdminMainPage(){
	window.location='specialManagement.php';
}

</script>
</html>