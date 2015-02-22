<?php

// echo sprintf('%.2f',$row['orderTotalPrice']);

if(!isset($_SESSION['isLogin'])){
	$_SESSION['isLogin']=0;
	$_SESSION['numInCart']=0;
	
}
// tool bar
if($_SESSION['isLogin']==0){
	echo 'Welcome, guest!&nbsp;&nbsp;&nbsp;';
	
	echo '<a href="productView.php">Main Page</a>';
	echo '&nbsp;&nbsp;&nbsp;';
	
	echo '<a href="specialView.php">Special Sale</a>';
	echo '&nbsp;&nbsp;&nbsp;';
	
	echo '<a href="login.php">Login</a>';
	echo '&nbsp;&nbsp;&nbsp;<a href="customerAddModifyForm.php">Register</a><br/>';
	
}
else{
	echo 'Welcome, '.$_SESSION['username'].'!&nbsp;&nbsp;&nbsp;';
	
	echo '<a href="productView.php">Main Page</a>';
	echo '&nbsp;&nbsp;&nbsp;';
	
	echo '<a href="specialView.php">Special Sale</a>';
	echo '&nbsp;&nbsp;&nbsp;';
	
	echo '<a href="outsideViewCart.php">Shopping Cart</a>';
	echo '&nbsp;&nbsp;&nbsp;';	
	
	echo '<a href="orderSummary.php">History Order</a>';
	echo '&nbsp;&nbsp;&nbsp;';	
	
	echo '<a href="customerAddModifyForm.php">Modify Profile</a>';
	echo '&nbsp;&nbsp;&nbsp;';
		
	echo '<a href="logout.php">Log out</a><br/>';
	
}

?>