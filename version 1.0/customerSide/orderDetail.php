<?php
session_start();		
require("sessionStart.php");
require('connectDB.php');
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Order Detail</title>
</head>

<body>
<h2>History Order Detail</h2>

<input type="button" value="Back" onClick="toBackPage()"/>
<script>
function toBackPage(){
	window.location='orderSummary.php';
}
</script>

<br/><br/>
<div style="display:inline;float:left;width:auto">
<table cellpadding="3">
	<tr><th colspan="5">Products</th></tr>
	<tr>
    	 <th>Image</th>
		 <th>Item</th>
        <th>Unit Price</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Special Sale</th>       
        
	</tr>

<?php 
$orderID = $_GET['orderID'];
$sql='select * from Orders where orderID='.$orderID;
$res = mysql_query($sql);
if(   $row=mysql_fetch_assoc($res) ) {
	$sql2='select * from OrderDetail where orderID='.$orderID;
	$res2 = mysql_query($sql2);
	while(   $row2=mysql_fetch_assoc($res2) ) {
		// find image & name
		$sql3='select productImage,productName from Product where productID='.$row2['productID'];
		
		$res3 = mysql_query($sql3);
	
		if( !$row3=mysql_fetch_assoc($res3) ) {
				die('Cannot retrieve product image');
		}		
		$image_file = '../upload/'.$row3['productImage'];
		$imageTag = '<img src="'.$image_file.'" width=50 height=50 style="vertical-align:middle"></li>';
		// echo
?>

	<tr>
    	<td><?php echo $imageTag; ?></td>
       <td><?php echo $row3['productName']; ?></td>
       <td>$<?php echo sprintf('%.2f',$row2['productPrice']); ?></td>
       <td><?php echo $row2['productQuantity']; ?></td>
       <td>$<?php echo sprintf('%.2f',$row2['productTotalPrice']); ?></td>
       <td>
		 <?php 
		 if( $row2['isSpecial']==1){ echo 'YES';}
		 else {echo 'NO';}
		  ?>
       </td> 
   </tr>
<?php 
	}
	?>       
       
    <tr><td colspan="5">Total:$<?php echo sprintf('%.2f',$row['orderTotalPrice']); ?></td></tr>	
</table>
</div>		
<?php
	$shippingTo = $row['shippingName'].'<br/>'.$row['shippingRoad'].'<br/>'.$row['shippingCity'].', '.$row['shippingState'];
	$billingTo = $row['billingName'].'<br/>'.$row['billingRoad'].'<br/>'.$row['billingCity'].', '.$row['billingState'];

?>


<div style="padding-right:100;display:inline;float:left;width:auto">
<table cellpadding="3"> 
<tr><th colspan="2">Other Info</th></tr>
<tr><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		 Order Date</th><td><?php echo $row['orderDate']; ?></td></tr>
<tr><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Shipping to</th><td><?php echo $shippingTo; ?></td></tr>
<tr><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Billing to</th><td><?php echo $billingTo; ?></td></tr>
<tr><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Credit Card Number</th><td><?php echo $row['creditCardNumber']; ?></td></tr>

<?php
}
echo '</table></div>';
// At the end of your PHP script
mysql_close($con);
?>


</body>
</html>