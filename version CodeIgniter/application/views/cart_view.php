<table cellpadding="3">
	<tr>
    	 <th>Image</th>
		 <th>Item</th>
        <th>Unit Price</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Del</th>
	</tr>
    
    
 <?php   
$username = $this->session->userdata('username');
if($username=='<>'){
	// Must use Session variables Until they login.
	$sum=0;
	$numInCart = $this->session->userdata('numInCart');	
	for( $i=1; $i<=$numInCart ; $i++ ){
		$cur = 'p'.$i.'_ID';
		$productID = $this->session->userdata($cur);
		
		if( $productID > 0 ){	// not deleted
			//find image
			$sql='SELECT productImage FROM Product WHERE productID='.$productID;
			$query = $this->db->query($sql);
			$row = $query->row_array();
			$imageTag = '<img src="'.base_url().'upload/'.$row['productImage'].'" 
								width=50 height=50 style="vertical-align:middle"></li>';
			// echo
			echo '<tr>';
						
			echo '<td>';
			echo $imageTag; 
			echo '</td>';
			
			echo '<td>';
			$cur = 'p'.$i.'_name';
			echo $this->session->userdata($cur).'&nbsp;&nbsp;&nbsp;'; 
			echo '</td>';
			
			echo '<td>';
			$cur = 'p'.$i.'_price';
			echo '$'.$this->session->userdata($cur); 
			echo '</td>';
			$unit = $this->session->userdata($cur);
			
			echo '<td>';
			$cur = 'p'.$i.'_quantity';	
			echo $this->session->userdata($cur);
			echo '</td>';
			$qty = $this->session->userdata($cur);
			
			$total = $unit*$qty;
			$sum += $total;
			echo '<td>'; // Total Price
			echo '$'.$total;
			echo '</td>';
			
			echo '<td>'; // DEL
			echo '<a href="'.base_url().'index.php/cart/delete_one_in_cart/'.$i.'">';
			echo '<img src="'.base_url().'upload/icon_x_red.png" style="align=center;vertical-align:middle">';
			echo '</a>';
			echo '</td>';
			
			echo '</tr>';
		}
	}
	echo '<tr>'; // DEL ALL
	echo '<td></td> <td></td>';
	
	echo '<td colspan="3"><br/>';
	echo '<a href="'.base_url().'index.php/cart/delete_all_in_cart/"> Empty Cart</a></td>';
	
	echo '</tr>'; 
	
	
	echo '<tr><td colspan="5">'; //subtotal
	echo 'Total: $'.$sum;
	echo '</td></tr>';
	
}

else{
	$sum=0;

	$sql='SELECT cartID,productImage,productName,Cart.productPrice,productQuantity FROM Cart,Product 
			WHERE customerID='.$this->session->userdata('customerID').
			' AND Cart.productID=Product.productID;';
	$query = $this->db->query($sql);

	foreach ($query->result_array() as $row){
		// find image
		$imageTag = '<img src="'.base_url().'upload/'.$row['productImage'].'" 
								width=50 height=50 style="vertical-align:middle"></li>';	
		// echo
		echo '<tr>';
	
		echo '<td>';
		echo $imageTag; 
		echo '</td>';
	
		echo '<td>';
		echo $row['productName'];
		echo '</td>';
		
		echo '<td>';
		echo '$'.$row['productPrice']; 
		echo '</td>';
		$unit = $row['productPrice'];		
			
		echo '<td>';
		echo $row['productQuantity'];
		echo '</td>';
		$qty = $row['productQuantity'];		

		$total = $unit*$qty;
		$sum += $total;
		echo '<td>'; // Total Price
		echo '$'.$total;
		echo '</td>';
			
		echo '<td>'; // DEL
		echo '<a href="'.base_url().'index.php/cart/delete_one_in_cart/'.$row['cartID'].'">';
			echo '<img src="'.base_url().'upload/icon_x_red.png" style="align=center;vertical-align:middle">';
			echo '</a>';
		echo '</td>';
		
		echo '</tr>';			
	}	 			

	echo '<tr>'; // DEL ALL
	echo '<td></td> <td></td>';
	
	echo '<td colspan="3"><br/>';
	echo '<a href="'.base_url().'index.php/cart/delete_all_in_cart/"> Empty Cart ';
	echo '</a>';
	
	echo '</tr>'; 
	
	
	echo '<tr><td colspan="5">'; //subtotal
	echo 'Total: $'.$sum;
	echo '</td></tr>';
	
	
}
?>


<tr><td colspan="5">
<form>
<input type="button" value="Add More Products" onClick="goToProductView()" />
<input type="button" value="Check Out" onClick="goToCheckOut()" />  
</form>	
</td></tr>
    



<script>
function goToProductView(){
	window.location='<?php echo base_url();?>index.php/product';
}
function goToCheckOut(){
	window.location='<?php echo base_url();?>index.php/cart/check_out';
}
</script>
