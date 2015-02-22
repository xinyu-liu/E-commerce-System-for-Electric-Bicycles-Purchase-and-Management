<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.0.js"></script>
<h2>History Order Detail</h2>
<input type="button" id='buttonTo' value="History Order Summary" />


<script>
$(document).ready(docReady);
function docReady(){
	$('#buttonTo').click(toBackPage);
}
function toBackPage(){
	window.location='  <?php echo base_url().'index.php/order/view_order_summary'; ?>  ';
}

</script>

<br/><br/>

<!--For products in OrderDetail table -->
<div style="display:inline;float:left;width:auto">
<table cellpadding="3">
	<tr><th colspan="6">Products</th></tr>
	<tr>
    	 <th>Image</th>
		 <th>Item</th>
        <th>Unit Price</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Special Sale</th>       
	</tr>

<?php 
$row=$row[0];
foreach ($row2_array as $row2){
	$imageTag = '<img height=50 width=50 src="'.base_url().'upload/'.$row2['productImage'].'" >';
?>
	<tr>
    	<td><?php echo $imageTag; ?></td>
       <td><?php echo $row2['productName']; ?></td>
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


<!--For other info in Order table -->		
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
</table></div>
