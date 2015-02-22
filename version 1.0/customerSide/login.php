<?php 
session_start(); 

require("sessionStart.php");
// start DB connection
require('connectDB.php');
error_reporting(E_ALL^E_NOTICE^E_WARNING);
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Login</title>
</head>

<body>

<?php

if($_SESSION['isLogin']==0){ // not login yet
	// require 'login.html';
	
	$username=$_POST['username'];
	$password=$_POST['password'];
	
	$errmsg='';
	if( strlen($username)==0 || strlen($password)==0 ) {
		$errmsg='Invalid login';
	}
	// first login, empty out error msg
	if( strlen($username)==0 && strlen($password)==0 ) {
		$errmsg='';
		require 'login.html';
	}
	
	// when both exist, validate to db
	if( strlen($username)>0 && strlen($password)>0 ) {
		$sql="select customerID from Customer where username='$username' and password=password('$password')";	
		$res = mysql_query($sql); 
		if(  !( $row=mysql_fetch_array($res) )  ){
			$errmsg='Invalid login';
		}
		
		// error case: missing un OR missing pw OR didn’t validate to db
		if( strlen($errmsg)>0 ){
	
			echo "<p style='color:red'>$errmsg</p>";
			require 'login.html';
		}
		// no user name & no password
		elseif( !$res ) {
			// $res is 0 if we didn’t talk to DB
			require 'login.html';
		}	
		else {
			// valid username and password, display appropriate page
			
			// $_SESSION['startTime']=time();//returns the current server time 
			$_SESSION['customerID'] = $row['0'];
			$_SESSION['username'] = $username;
				
			// store All Session Into DB			
			for( $i=1; $i<=$_SESSION['numInCart'] ; $i++ ){
				$cur = 'p'.$i.'_name';
				unset($_SESSION[ $cur ]);		
								
				$customerID = $row['0']; //
										
				$cur = 'p'.$i.'_ID';
				$productID = $_SESSION[ $cur ]; //
				unset($_SESSION[ $cur ]);
			
				$cur = 'p'.$i.'_price';	
				$productPrice = $_SESSION[ $cur ]; //
				unset($_SESSION[ $cur ]);
						
				$cur = 'p'.$i.'_quantity';	
				$productQuantity = $_SESSION[ $cur ]; //
				
				$productTotalPrice = $productPrice * $productQuantity;
				unset($_SESSION[ $cur ]);
				$sql='INSERT INTO Cart(productID, productQuantity, productPrice, productTotalPrice, customerID) 
					  VALUES ('.$productID.', '.$productQuantity.', '.$productPrice.',  '.$productTotalPrice.', '.$customerID.');';
				echo '<br>';
					
				$res = mysql_query($sql); 
				if(  ! $res  ){
					die('Invalid insert into database cart');
				}
			}
			unset($_SESSION['numInCart']);
									
			$_SESSION['isLogin']  = 1;
			echo '<script>window.location="'.$_SESSION['previousPage'].'";</script>';
			
		} 
	}
}
else{ // have login before
	echo 'You have logged in as '.$_SESSION['username'].'.';
			
	echo '<form action="logout.php">';
	echo '	<input type="button" value="Back" onClick="toGoBack()"/>';
	echo '	<input type="submit" name="logout" value="Logout" />';
	echo '</form>';
	
}

// end DB connection
mysql_close($con);
?>
<script>
function toGoBack(){
	history.go(-1);
}
</script>
</body>
</html>