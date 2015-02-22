<?php
session_start();
require("sessionStart.php");
require('connectDB.php');

if($_SESSION['isLogin']==0){
	echo $_GET['index'];
	$cur = 'p'.$_GET['index'].'_ID';
	$_SESSION[ $cur ]=-1; // marked as deleted
}
elseif($_SESSION['isLogin']==1){
	$sql='DELETE FROM Cart WHERE cartID= '.$_GET['cartID'].';';		
	$res = mysql_query($sql); 
	if(  ! $res  ){
		die('Invalid delete one item in table cart');
	}
}
// end DB connection
mysql_close($con);

require ('insideViewCart.php');
$_SESSION['previousPage']='outsideViewCart.php';
?>