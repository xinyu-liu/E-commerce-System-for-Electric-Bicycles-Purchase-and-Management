<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.0.js"></script>
<h2>History Order Summary</h2>

<input type="button" id="toMain" value="Main Page" onClick="toMainPage()"/>
<script>
$(document).ready(docReady);
function docReady(){
	$("#toMain").click(toMainPage);
}
function toMainPage(){
	window.location=" <?php echo base_url().'index.php/product'; ?> ";
}
</script>

<br/><br/>

<table cellpadding="5"> 
<tr><th>Order Date</th><th>Total Price</th><th>Shipping to</th><th>Details</th></tr>

<?php 
foreach ($row_array as $row){
	$shippingTo = $row['shippingName'].'<br/>'.$row['shippingRoad'].'<br/>'.$row['shippingCity'].', '.$row['shippingState'];
	$detail = '<a href="'.base_url().'index.php/order/view_order_detail/'. $row['orderID'].'">Detail</a>';
	
	echo '<tr>
	<td>'.$row['orderDate'].'</td>
	<td>$'.sprintf('%.2f',$row['orderTotalPrice']).'</td>
	<td>'.$shippingTo.'</td>
	<td>'.$detail.'</td>
	</tr>';
}
?>

</table>
</body>
</html>