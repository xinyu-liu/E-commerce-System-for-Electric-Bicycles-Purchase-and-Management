<?php
session_start();
if($_SESSION['isLogin']==0){
	if ($_SESSION['numInCart']>0) {
		$_SESSION['previousPage']='checkOut.php';
		echo "<script>window.location='login.php';</script>";
		// finish add session to table
	}
}
elseif($_SESSION['isLogin']==1){
	require ('orderForm.html');
}

?>
