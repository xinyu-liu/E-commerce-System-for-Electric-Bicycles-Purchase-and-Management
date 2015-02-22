<?php
session_start();		
require("sessionStart.php");
require('connectDB.php');
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Order Summary</title>
</head>

<body>
<h2>History Order Summary</h2>

<input type="button" value="Main Page" onClick="toMainPage()"/>
<script>
function toMainPage(){
	window.location='productView.php';
}
</script>

<br/><br/>

<table cellpadding="5"> 
<tr><th>Order Date</th><th>Total Price</th><th>Shipping to</th><th>Details</th></tr>

<?php 
$sql='select orderID, orderDate, orderTotalPrice, shippingName, shippingRoad, shippingCity, 
		shippingState from Orders where customerID='.$_SESSION['customerID'].' ORDER BY orderDate DESC';
$res = mysql_query($sql);
	
while(   $row=mysql_fetch_assoc($res) ) {
	$shippingTo = $row['shippingName'].'<br/>'.$row['shippingRoad'].'<br/>'.$row['shippingCity'].', '.$row['shippingState'];
	$detail = '<a href="orderDetail.php?orderID='.$row['orderID'].'">Detail</a>';
	echo '<tr><td>'.$row['orderDate'].'</td><td>$'.sprintf('%.2f',$row['orderTotalPrice']).'</td><td>'.$shippingTo.'</td><td>'.$detail.'</td></tr>';

}
echo '</table>';
// At the end of your PHP script
mysql_close($con);
?>


</body>
</html>