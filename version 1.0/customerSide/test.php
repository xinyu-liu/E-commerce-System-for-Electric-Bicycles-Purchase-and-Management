<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
<?php 
$normImageSize = 250; /////

$sql1="SELECT * FROM ProductCategory";
require('connectDB.php');
// special product?
/*		$sql3='SELECT * FROM SpecialSale WHERE productID="9";';
		$res3 = mysql_query($sql3);
$isSpecialPrice=9999;

		while( $row3=mysql_fetch_assoc($res3) ) {	
			$startDate=strtotime($row3['startDate']);
			$endDate = strtotime($row3['endDate']);
			$today=strtotime('now');
			// for compare
			
			if ($startDate <= $today && $today < $endDate) {
				if($isSpecialPrice>$row3['specialPrice']){
					echo 'yes';
					$isSpecialPrice=$row3['specialPrice'];
				}
			}
			// for print
			echo 'startDate='.date("Y-m-d h:i:sa", $startDate).
			'  endDate = '.date("Y-m-d h:i:sa", $endDate).
			'  today = '.date("Y-m-d h:i:sa", $today).
			'  price = '  .$row3['specialPrice'].
			'  price = '  .$isSpecialPrice;
		}
		*/
		$sql3='SELECT min(specialPrice) FROM SpecialSale WHERE productID=9 AND endDate>=CURDATE() AND startDate<=CURDATE();';
		$res3 = mysql_query($sql3);
		
		if( $row3=mysql_fetch_array($res3) ) {	
			$specialPrice=$row3[0];
			// for print
			echo ' price = '  .$specialPrice;
		}
		// find specialSaleID endDate
		$sql3='SELECT specialSaleID, endDate FROM SpecialSale WHERE productID=9 AND specialPrice='.$specialPrice.';';
		$res3 = mysql_query($sql3);
		if( $row3=mysql_fetch_assoc($res3) ) {	
			$specialSaleID=$row3['specialSaleID'];
			$endDate=$row3['endDate'];
			// for print
			echo 'endDate = '.$endDate.
			'  specialSaleID = '.$specialSaleID;
			///////////////
/*
$d1=strtotime("July 3");
$d2=ceil(($d1-time())/60/60/24)+2;
echo "距离十二月三十一日还有budao：" . $d2 ." 天。";
*/

			$d1=strtotime($endDate);
			$d2=ceil(($d1-time())/60/60/24)+2;
			echo "Less than " . $d2 ." days";

		}
		
		mysql_close($con);
?>
</body>
</html>