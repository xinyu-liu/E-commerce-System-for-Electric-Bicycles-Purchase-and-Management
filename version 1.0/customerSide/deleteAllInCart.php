<?php
session_start();
require("sessionStart.php");
require('connectDB.php');


if($_SESSION['isLogin']==0){
	// echo $_SESSION['numInCart'];
	for( $i=1; $i<=$_SESSION['numInCart'] ; $i++ ){
		$cur = 'p'.$i.'_ID';
		unset($_SESSION[ $cur ]);

		$cur = 'p'.$i.'_name';
		unset($_SESSION[ $cur ]);
	
		$cur = 'p'.$i.'_price';	
		unset($_SESSION[ $cur ]);
			
		$cur = 'p'.$i.'_quantity';		
		unset($_SESSION[ $cur ]);	
		
	}	
	$_SESSION['numInCart']=0;	
}
elseif($_SESSION['isLogin']==1){
	$sql='DELETE FROM Cart WHERE customerID= '.$_SESSION['customerID'].';';		
	$res = mysql_query($sql); 
	if(  ! $res  ){
		die('Invalid delete all items for this customer in table cart');
	}
}

// end DB connection
mysql_close($con);

require ('insideViewCart.php');
$_SESSION['previousPage']='outsideViewCart.php';
?>