<?php
// require("sessionStart.php");
if(!isset($_SESSION['isLogin'])){
	echo "get in";
	$_SESSION['isLogin']=0;
	$_SESSION['numInCart']=0;
}

require('connectDB.php');

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>My Shopping Cart</title>
</head>

<body>
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
if($_SESSION['isLogin']==0){
	// Must use Session variables Until they login.
	$sum=0;
	for( $i=1; $i<=$_SESSION['numInCart'] ; $i++ ){
		$cur = 'p'.$i.'_ID';
		$productID = $_SESSION[ $cur ];
		
		if($_SESSION[ $cur ]>0){	// not deleted
			//find image
			$sql='SELECT productImage FROM Product WHERE productID='.$productID;
			$res = mysql_query($sql); 
			if( !$row=mysql_fetch_array($res) ) {
				die('Cannot retrieve product image');
			}
			
			$image_file = '../upload/'.$row[0];
			$imageTag = '<img src="'.$image_file.'" width=50 height=50 style="vertical-align:middle"></li>';
			// echo
			echo '<tr>';
						
			echo '<td>';
			echo $imageTag; 
			echo '</td>';
			
			echo '<td>';
			$cur = 'p'.$i.'_name';
			echo $_SESSION[ $cur ].'&nbsp;&nbsp;&nbsp;'; 
			echo '</td>';
			
			echo '<td>';
			$cur = 'p'.$i.'_price';
			echo '$'.$_SESSION[ $cur ]; 
			echo '</td>';
			$unit = $_SESSION[ $cur ];
			
			echo '<td>';
			$cur = 'p'.$i.'_quantity';	
			echo $_SESSION[ $cur ];
			echo '</td>';
			$qty = $_SESSION[ $cur ];
			
			$total = $unit*$qty;
			$sum += $total;
			echo '<td>'; // Total Price
			echo '$'.$total;
			echo '</td>';
			
			echo '<td>'; // DEL
			echo '<a href="deleteOneInCart.php?index='.$i.'">';
			echo '<img src="images/icon_x_red.png" style="align=center;vertical-align:middle">';
			echo '</a>';
			echo '</td>';
			
			echo '</tr>';
		}
	}
	echo '<tr>'; // DEL ALL
	echo '<td></td> <td></td>';
	
	echo '<td colspan="3"><br/>';
	echo '<a href="deleteAllInCart.php"> Empty Cart ';
	echo '<img src="images/icon_x_red.png" style="align=center;vertical-align:middle"></td>';
	echo '</a>';
	
	echo '</tr>'; 
	
	
	echo '<tr><td colspan="5">'; //subtotal
	echo 'Total: $'.$sum;
	echo '</td></tr>';
	
}
elseif($_SESSION['isLogin']==1){
	$sum=0;

	$sql='SELECT cartID,productImage,productName,Cart.productPrice,productQuantity FROM Cart,Product 
			WHERE customerID='.$_SESSION['customerID'] .
			' AND Cart.productID=Product.productID;';
	$res = mysql_query($sql); 
	while( $row=mysql_fetch_assoc($res) ) {
		// find image
		$image_file = '../upload/'.$row['productImage'];
		$imageTag = '<img src="'.$image_file.'" width=50 height=50 style="vertical-align:middle"></li>';
			
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
		echo '<a href="deleteOneInCart.php?cartID='.$row['cartID'].'">';
		echo '<img src="images/icon_x_red.png" style="align=center;vertical-align:middle">';
		echo '</a>';
		echo '</td>';
		
		echo '</tr>';			
	}	 			

	echo '<tr>'; // DEL ALL
	echo '<td></td> <td></td>';
	
	echo '<td colspan="3"><br/>';
	echo '<a href="deleteAllInCart.php"> Empty Cart ';
	echo '<img src="images/icon_x_red.png" style="align=center;vertical-align:middle"></td>';
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
	window.location='productView.php';
}
function goToCheckOut(){
	window.location='checkOut.php';
}
</script>
<?php 
// end DB connection
mysql_close($con);
?>
</body>
</html>