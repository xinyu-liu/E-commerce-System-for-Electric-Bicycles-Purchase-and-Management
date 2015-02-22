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
<title>Product Form</title>
</head>

<body>
<input type="button" value="Product Management Page" onClick="toAdminMainPage()"/>
<?php
$productID="";
if(isset($_POST['modify'])){
	$productID=$_POST['modify'];
}
//////////// for title ////////////////////
if(!$productID){
	// not exist, it is an add
	echo '<h2>Add a Product</h2>';
}
else{
	// it is a modify
	echo '<h2>Modify a Product</h2>';
}
?>
<?php
$con=mysql_connect('localhost','lxy','1320');
if(!$con){
	die ('Could not connect to database'.mysql_error() );
}
mysql_select_db('company571',$con);

//////// for filled in form ////////////////
if($productID){
	// modify
	$sql=" select * from Product where productID='$productID' ";
	$res=mysql_query($sql,$con);		
	if(  !( $row=mysql_fetch_assoc($res) )  ){
		die ('Invalid productID');
	}
	$productCategoryName=findProductCategoryName($row['productCategoryID']);
}

//////// for radio button value ////////////////
$sql2="select productCategoryName from productCategory";
	$res2=mysql_query($sql2);
?>

<form name="f2"  method="POST" onsubmit="return toValidate()" action="productAddModifyFormSubmit.php">

<input type="hidden" name="productID" <?php if($productID){ echo 'value="'.$row['productID'].'"'; }?> >
<table>
	<tr>
		<th>*Product Name: </th>
        <td><input type="text" name="productName" maxlength="20" 
				<?php if($productID){ echo 'value="'.$row['productName'].'"'; }?>/></td>          
   	</tr>
    <tr>
		<th>*Product Category Name: </th>
        <td>
<?php
while($row2=mysql_fetch_array($res2)){
?>	
        <input type="radio" name="productCategory" 
       			 value="<?php echo $row2[0];?>"
                 <?php if($productID && $productCategoryName== $row2[0])
				 		 {echo ' checked="checked" ';} 
					?>
         > 	<?php echo $row2[0];?>		</input> <br/>
        
<?php
}
?>
        </td> 
   	</tr>  
    <tr>
		<th>*Product Price: </th>
        <td><input type="text" name="productPrice" maxlength="20" 
        			 onChange="checkPrice()" 
              		<?php if($productID){ echo 'value="'.$row['productPrice'].'"'; }?>
              /></td>
     
   	</tr>  
	<tr>
	<th>Product Description: </th>
        <td><textarea rows="20" cols="40" name="productDescription"><?php if($productID){ echo $row['productDescription']; }?></textarea></td>
   	</tr>
	  
	<tr>
		<th>Product Image: </th>
       <td><input type="text" name="productImage" maxlength="255" 
				<?php if($productID){ echo 'value="'.$row['productImage'].'"'; }?>/></td>       
   	</tr>
</table>

  
<?php
////////// for submit button ///////////////
echo '<input type="submit" name="addModifyProductFormSubmit" value=" ';
if(!$productID){
	// add
	echo 'Add Product';
}
else{
	// modify
	echo 'Modify Product';
}
echo '"/></form> ';


mysql_close($con);
?>

<script>

function checkPrice()
{
	var pattern=/^(\d*\.)?\d+$/;
	var a = document.f2.productPrice.value; 
	if(!a.match(pattern))
	{
	 	alert("Please input a valid price");
		document.f2.productPrice.value="";
	}
}

function toValidate(){
	var f = document.f2;
	var totalB = true;
	for(i=0;i<1;i++){
		e = f.productName;		a="Product name is required!";		
		b=requiredElem(e,a);
		totalB=totalB&&b;		if(!totalB){break;}

		e = f.productCategory;		b=isRadioChecked(e); 	
		if (!b){alert("Product Category is required");}
		totalB=totalB&&b; 		if(!totalB){break;}
			
		e = f.productPrice;		a="Product price is required!";	
		b=requiredElem(e,a);	
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
	window.location='productManagement.php';
}
</script>
<?php
function findProductCategoryName($id){
	$productCategoryName='';
	$sql3="select * from productCategory";
	$res3 = mysql_query($sql3);
	$b=false;
	while($row3=mysql_fetch_assoc($res3)){
		 if($id==$row3['productCategoryID']){
			 $productCategoryName=$row3['productCategoryName'];
			 return $productCategoryName;
		 }
	}
	return $productCategoryName;
}
?>
</body>
</html>