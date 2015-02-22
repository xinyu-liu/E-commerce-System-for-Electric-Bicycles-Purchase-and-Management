<h2>Guess You Like</h2>

<?php

for ($i=1;$i<3;$i++){
	if($i==1){
		$sql = 'SELECT productID,sum(productQuantity) as sumQ FROM OrderDetail 
				GROUP BY productID ORDER BY sumQ DESC';
	}
	else {
		$sql = 'SELECT abc.productID as productID,sum(abc.productQuantity) as sumQ FROM 
				(SELECT * FROM OrderDetail WHERE orderID 
					IN (SELECT DISTINCT orderID FROM OrderDetail WHERE productID='.$productID.')) abc 
				GROUP BY productID ORDER BY sumQ DESC';
	}
	$res = mysql_query($sql);
	$row = mysql_fetch_assoc($res);
	if(!$row) {
		$error= 'No sell record';
	}
	else{
		$sql2='SELECT * FROM Product WHERE productID = '.$row['productID'];
		$res2 = mysql_query($sql2);
		$row2 = mysql_fetch_assoc($res2);
		if(!$row2) {
			die('Wrong');
		}
		// DEAL WITH IMAGE
		$image_file = '../upload/'.$row2['productImage']; 	
		// special product?
		$specialPrice;
		$specialSaleID=-1;
		$endDate;
		$dayLeft=-1;
		$price = $row2['productPrice'];
			
		$sql3='SELECT min(specialPrice) FROM SpecialSale WHERE productID="'.$row2['productID'].'" AND endDate>=CURDATE() AND startDate<=CURDATE();';
		$res3 = mysql_query($sql3);		
		if( $row3=mysql_fetch_array($res3) ) {	
			$specialPrice=$row3[0];
		}
		if($specialPrice!=NULL && $specialPrice!="" && $specialPrice < $price){
			// find specialSaleID and endDate
			$sql4='SELECT specialSaleID, endDate FROM SpecialSale WHERE productID="'.$row2['productID'].'" AND specialPrice='.$specialPrice.';';
			//echo $sql4;
			$res4 = mysql_query($sql4);
			if( $row4=mysql_fetch_assoc($res4) ) {	
				$specialSaleID=$row4['specialSaleID'];
				$endDate=$row4['endDate'];
				// days left
				$d1=strtotime($endDate);
				$dayLeft=ceil(($d1-time())/60/60/24)+2;
				// echo "Less than " . $dayLeft ." days left";
			}
		}
		// end special product?
	}
	if($i==1)
	{
		echo '<table cellpadding="5"><tr><th>Most Popular</th><th>People Who Buy This Product Also Buy</th></tr>';
		echo '<tr>';
	}
	if(!$row) {
		echo '<td align="center">None</td>';
	}
	else{
		echo '<td width="250" align="center"><ul style="list-style-type:none">';
		echo '<a href="selectProductForm.php?productID='.$row2['productID'].'&specialSaleID='.$specialSaleID.'&specialPrice='.$specialPrice.'">';
		echo '<li align="center"><img src="'.$image_file.'" width="250" height="250" align="center" style="vertical-align:middle"></li>';
		echo '<li align="center"><span style="font-size:18pt">'.$row2['productName'].'</span></li>';
		echo '</a>';
		echo '<li align="center">';
		if($specialPrice!=NULL && $specialPrice!="" && $specialPrice < $price){ //sepcial!
			echo '<span style="font-size:14pt; color:black"><s> Price:&nbsp;&nbsp;&nbsp;&nbsp;'.$row2['productPrice'].' </s></span><br /><br />';
			echo '<div style="font-size:18pt; color:orange">SALE:&nbsp;&nbsp;&nbsp;&nbsp;'.$specialPrice.'</div>';
			echo '<div style="color:orange">Less than ' . $dayLeft .' days left</div>';
		}
		else{//Original!
			echo '<span style="font-size:14pt; color:black">Price: '.$row2['productPrice'].'</span><br />';
		}
		echo '</li>
				</ul></td>';
	}
	if($i!=1){
		echo '</tr></table>';
	} 
}
			
?>