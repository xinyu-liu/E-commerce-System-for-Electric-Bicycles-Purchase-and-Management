
<?php 
$max=3;

$num=0;
foreach ($categories as $row){
	echo '<table cellpadding="10">';
	echo '<tr><th colspan="3" >'.$row['productCategoryName'].'</th></tr>';
	echo '<tr><td colspan="3" align="center"><i>Category Description:'.$row['productCategoryDescription'].'</i></td></tr>';
	
	$count=0;
	$hasProduct=0;	

	$temp='c_'.$num;
	
	// per product
	foreach (${$temp} as $perRow){
		$count++;
		$hasProduct=1;
		// special ?
		$specialPrice=-1;
		foreach ($special as $perSpecial){
			if($perSpecial['productID'] == $perRow['productID']){
				$specialPrice = $perSpecial['specialPrice'];
			}
		}
		// position
		if($count%$max==1){
			echo '<tr>';	
		}
		// output
		echo '<td width="250" align="center">';
		
		echo '<a href="'.base_url().'index.php/cart/select/'.$perRow['productID'].'">';
		echo '<img height=250 width=250 src="'.base_url().'upload/'.$perRow['productImage'].'" ><br/>';
		echo '<b>'.$perRow['productName'].'</b><br/>';
		echo '</a>';
		
		
		if($specialPrice!=-1){ //sepcial!
			echo '<s>';
		}
		echo 'Price:&nbsp;$'.sprintf('%.2f',$perRow['productPrice']);
		if($specialPrice!=-1){ //sepcial!
			echo '</s>';
		}
		echo '<div style="font-size:16pt; color:red">&nbsp;';
		if($specialPrice!=-1){ //sepcial!
			echo 'SALE:&nbsp;$'.sprintf('%.2f',$specialPrice);
		}
		echo '</div></td>';
		
		// position
		if($count % $max==0){
			echo '</tr>';	
		}
	}
	
	if($count==0 && $hasProduct==0){
		echo '<tr><td width="750" align="center">Out Of Stock Currently</td></tr>';
	}
	
	$num++;
	echo '</table><br/>';
}


?>