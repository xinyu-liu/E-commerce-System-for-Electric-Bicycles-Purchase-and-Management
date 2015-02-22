<?php
session_start(); 
require("sessionStart.php");
require('connectDB.php');
if($_SESSION['isLogin']==0){
	// Must use Session variables Until they login.
	++$_SESSION['numInCart'];
	
	$cur = 'p'.$_SESSION['numInCart'].'_ID';
	$_SESSION[ $cur ] = $_POST['productID'];
	
	$cur = 'p'.$_SESSION['numInCart'].'_name';
	$_SESSION[ $cur ] = $_POST['productName'];
	
	$cur = 'p'.$_SESSION['numInCart'].'_price';
	$_SESSION[ $cur ] = $_POST['productFinalPrice'];
	
	$cur = 'p'.$_SESSION['numInCart'].'_quantity';	
	$_SESSION[ $cur ] = $_POST['quantity'];


}
elseif($_SESSION['isLogin']==1){ 
	$customerID = $_SESSION['customerID'] ;
	$productID = $_POST['productID'];
	$productPrice = $_POST['productFinalPrice'];	
	$productQuantity = $_POST['quantity'];
	$productTotalPrice = 	$productPrice * $productQuantity;

	$sql='INSERT INTO Cart(productID, productQuantity, productPrice, productTotalPrice, customerID) 
		VALUES ('.$productID.', '.$productQuantity.', '.$productPrice.', '.$productTotalPrice.', '.$customerID.');';
					
	$res = mysql_query($sql); 
	if(  ! $res  ){
		die('Invalid insert into database cart');
	}


}
// end DB connection
mysql_close($con);

require ('insideViewCart.php');
$_SESSION['previousPage']='outsideViewCart.php';
?>