<?php 
session_start(); 
require("sessionStart.php");
require("previousPage.php");
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Special Sale</title>
</head>

<body>
<h2>Special Sale</h2>

<?php 
$normImageSize = 250; /////
$perRow=3;
$count=0;
$sql1="SELECT * FROM ProductCategory";
require('connectDB.php');
$res1 = mysql_query($sql1);
while(   $row1=mysql_fetch_assoc($res1) ) {
	$count=0;
	$hasProduct=0;	
	echo '<table cellspacing="10"><tr><th colspan="120" >'.$row1['productCategoryName'].'</th></tr>';
		
	$sql2='SELECT * FROM Product,ProductCategory WHERE Product.productCategoryID="'.$row1['productCategoryID'].'" AND Product.productCategoryID=ProductCategory.productCategoryID;';
	$res2 = mysql_query($sql2);
	

	// special product?
	$specialPrice;
	$specialSaleID=-1;
	$endDate;
	$dayLeft=-1;

	while( $row2=mysql_fetch_assoc($res2) ) {
		$specialSaleID=-1;
		$hasProduct=1;	
		// DEAL WITH IMAGE
		$image_file = '../upload/'.$row2['productImage']; 
		$image_size = getimagesize($image_file); 
		if($image_size[0]<$image_size[1]){ // width<hight
			$height=$normImageSize;
			$width=floor($normImageSize/$image_size[1]*$image_size[0]);
		}
		else{ // width>height
			$width=$normImageSize;
			$height=floor($normImageSize/$image_size[0]*$image_size[1]);
			$relative= $normImageSize-$height; //echo $normImageSize."-".$height."=".$relative;
		}
		
		// special product?
		$specialPrice;
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

		// output 
		if($specialPrice!=NULL && $specialPrice!="" && $specialPrice < $price){
			
			// position
			$count++;
			$reminder = $count % $perRow;
			
			if($reminder==1){
				echo '<tr>';
			}	
			
	
			echo '<td width="250" align="center"><ul style="list-style-type:none">';
			echo '<a href="selectProductForm.php?productID='.$row2['productID'].'&specialSaleID='.$specialSaleID.'&specialPrice='.$specialPrice.'">';
			echo '<li><img src="'.$image_file.'" width="'.$width.'" height="'.$height.'" style="vertical-align:middle"></li>';
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
					</ul><td/>';
				
			if($reminder==0){
				echo '</tr>';
			}		
		}
		//$row2['productDescription']
				
		// echo '<tr><td>'.$row2['productName'].'</td><td>'.$row2['productPrice'].'</td><td width="250" height＝"250" align="center"><img src="'.$image_file.'" width="'.$width.'" height="'.$height.'"></td><td>'.$row2['productDescription'].'</td></tr>';
	}
	
	if( $count==0 ){
		echo '<tr><td width="250"></td><td width="250">No Special Sale For This Category</td><td width="250"></td></tr>';
	}
	else if( $count==1 ){
		echo '<td width="250"></td><td width="250"></td></tr>';
	}
	else if( $count==2 ){
		echo '<td width="250"></td></tr>';
	}		

	echo '</table><br/>';
}

// At the end of your PHP script
mysql_close($con);

?>


</body>
</html>