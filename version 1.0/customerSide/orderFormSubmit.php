<?php
session_start();		
require("sessionStart.php");
require('connectDB.php');
?>
<?php
if (toValidate()){
/*	
$_SESSION['customerID']
$_POST['shippingName']
$_POST['shippingRoad']
$_POST['shippingCity']
$_POST['shippingState']
*/
	$shippingPhone=$_POST['shippingPhone1'].'-'.$_POST['shippingPhone2'].
				'-'.$_POST['shippingPhone3'];
	$creditCardNumber=$_POST['creditCardNumber1'].'-'.$_POST['creditCardNumber2'].
					'-'.$_POST['creditCardNumber3'].'-'.$_POST['creditCardNumber4'];
	// get cartTotalPrice					
	$sql='SELECT sum(productTotalPrice) as cartTotalPrice FROM Cart WHERE customerID='.$_SESSION['customerID'];	
	$res = mysql_query($sql);
	if(!$row=mysql_fetch_array($res) ) {
		die('Wrong CurrentImageNum table');
	}
	$cartTotalPrice = $row[0];
	
	
	
	mysql_query('START TRANSACTION');
	$isBad = 0;
	// add to Orders table					
	$sql2 = 'INSERT INTO Orders(customerID, orderTotalPrice, orderDate, 
				shippingName, shippingRoad, shippingCity, shippingState, shippingPhone, 
				creditCardNumber, creditCardPin, 
				billingName, billingRoad, billingCity, billingState) 
			 VALUES ('.$_SESSION['customerID'].','.$cartTotalPrice.',NOW(),"'.
				$_POST['shippingName'].'","'.$_POST['shippingRoad'].'","'.$_POST['shippingCity'].'","'.$_POST['shippingState'].'","'.$shippingPhone.'",
				"'.$creditCardNumber.'",'.$_POST['creditCardPin'].',
				"'.$_POST['billingName'].'","'.$_POST['billingRoad'].'","'.$_POST['billingCity'].'","'.$_POST['billingState'].'"	);';	
	$res2 = mysql_query($sql2);
	if(!$res2) {
		$isBad =1;
	}
		
	// find orderID					
	$orderID;
	$sql3 = 'SELECT max(orderID) FROM Orders;'; 
	$res3 = mysql_query($sql3);
	if(!$row3=mysql_fetch_array($res3) ) {
		$isBad =1;
	}
	else{
		$orderID = $row3[0];
	}
	
	// add to OrderDetail table
		// get all information in table Cart 					
	$sql='SELECT * FROM Cart WHERE customerID='.$_SESSION['customerID'];	
	$res = mysql_query($sql);
	while($row=mysql_fetch_assoc($res) ) {
		// already get one row in table Cart
		// get original price & isSpecial
		$sql1='SELECT productPrice FROM Product WHERE productID='.$row['productID'];	
		$res1 = mysql_query($sql1);
		if(!$row1=mysql_fetch_array($res1) ) {
			die('Wrong original price');
		}
		$originalPrice = $row1[0];
		
		$isSpecial ;
		if($row['productPrice']<$originalPrice ){
			$isSpecial = 1;
		}
		else{
			$isSpecial = 0;
		}
		
		// add to OrderDetail table	
		$sql1 = 'INSERT INTO OrderDetail(productID, productQuantity, productPrice, productTotalPrice, isSpecial, orderID) 
				  VALUES ('.$row['productID'].', '.$row['productQuantity'].', '.$row['productPrice'].', '.$row['productTotalPrice'].', '.$isSpecial.', '.$orderID.');';
		
		$res1 = mysql_query($sql1);
		if(!$res1) {
			$isBad =1;
		}		
	}
	// delete rows in Cart table					
	$sql4 = 'DELETE FROM Cart WHERE customerID ='.$_SESSION['customerID'].';';
	$res4 = mysql_query($sql4);
	if(!$res4) {
		$isBad =1;
	}
	
	if($isBad == 1){
		die ('Not succeed');
    	mysql_query('ROLLBACK');
	}	
	else{
		mysql_query('COMMIT');
	}
	echo '<script>window.location.href="orderDetail.php?orderID='.$orderID.'";</script>';	

}
else{
	die('Not validated');
}
?>
<?php
function toValidate(){
	$totalB = true;


	$b = filter_var($_POST['shippingName'],FILTER_SANITIZE_STRING);
	$totalB= $totalB && $b;

	$b = filter_var($_POST['shippingRoad'],FILTER_SANITIZE_STRING);
	$totalB= $totalB && $b;

	$b = filter_var($_POST['shippingCity'],FILTER_SANITIZE_STRING);
	$totalB= $totalB && $b;
	
//	$b = filter_var($_POST['shippingState'], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[A-Z]{2}$/")));
	$totalB= $totalB && $b;
	
	$b = filter_var($_POST['shippingPhone1'], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[1-9]+\d{2}$/")));
	$totalB= $totalB && $b;
	$b = filter_var($_POST['shippingPhone2'], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\d{3}$/")));
	$totalB= $totalB && $b;
	$b = filter_var($_POST['shippingPhone3'], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\d{4}$/")));
	$totalB= $totalB && $b;
	
	$b = filter_var($_POST['creditCardNumber1'], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\d{4}$/")));
	$totalB= $totalB && $b;	
	$b = filter_var($_POST['creditCardNumber2'], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\d{4}$/")));
	$totalB= $totalB && $b;
	$b = filter_var($_POST['creditCardNumber3'], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\d{4}$/")));
	$totalB= $totalB && $b;
	$b = filter_var($_POST['creditCardNumber4'], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\d{4}$/")));
	$totalB= $totalB && $b;
	
	$b = filter_var($_POST['creditCardPin'], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\d{3}$/")));
	$totalB= $totalB && $b;
	
	$b = filter_var($_POST['billingName'],FILTER_SANITIZE_STRING);
	$totalB= $totalB && $b;

	$b = filter_var($_POST['billingRoad'],FILTER_SANITIZE_STRING);
	$totalB= $totalB && $b;

	$b = filter_var($_POST['billingCity'],FILTER_SANITIZE_STRING);
	$totalB= $totalB && $b;
	
//	$b = filter_var($_POST['billingState'], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[A-Z]{2}$/")));
	$totalB= $totalB && $b;

	return $totalB;
}

// end DB connection
mysql_close($con);
?>