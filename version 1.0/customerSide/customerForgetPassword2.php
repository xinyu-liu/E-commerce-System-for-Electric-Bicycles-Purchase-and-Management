<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Change Your Password</title>
</head>

<body>

<?php
if (toValidate()){	
	// Connect to your database software
	$con = mysql_connect('localhost','lxy','1320');
	// check if connection fails
	if(!$con){
		die ('Could not connect to database'.mysql_error() );
	}

	// Select a database
	mysql_select_db('company571',$con);
	
	
	$sql='select customerID from Customer where username="'.$_POST['username'].'" AND email="'.$_POST['email'].'"';
	
	$res = mysql_query($sql); 
	if(  !( $row=mysql_fetch_array($res) )  ){
		echo '<script>alert("Cannnot retrieve this Customer.Wrong username or (and) wrong email.");history.go(-1);</script>';
		
	}

	echo '<form name="f1"  method="POST" onsubmit="return toValidate()" action="customerForgetPassword3.php">';
	echo '<input type="hidden" name="customerID" value="'.$row[0].'" maxlength="20">';
	echo '<table>';
	echo '<tr>';
	echo '	<th>username:</th>';
    echo '    <td>'.$_POST['username'].'</td>';
   	echo '</tr>';
	echo '<tr>';
	echo '	<th>*Password:</th>';
    echo '    <td><input type="password" name="password" maxlength="20"></td>';
   	echo '</tr>    ';
	echo '</table>';
  
	////////// for submit button ///////////////
	echo '<input type="submit" value="Submit"/>';
	
	echo '<input type="button" value="Main Page" onClick="toMainPage()"/></form> ';

	// end DB connection
	mysql_close($con);
	
	





}
else{
	die('Not validated');
}

?>
<?php
function toValidate(){
	$totalB = true;

	$b = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
	$totalB= $totalB && $b;
	
	$b = filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);
	$totalB= $totalB && $b;
	
	return $totalB;
}
?>

<script>

function toValidate(){
	var f = document.f1;
	e = f.password;		a="Password is required!";		b=requiredElem(e,a);	
	return b;
}
function requiredElem(elemObj,alertText){
	if(elemObj.value==null || elemObj.value.trim() ==""){
		window.alert(alertText);
		return false;
	}
	else{
		return true;
	}
}
function toMainPage(){
	window.location='productView.php';
}
</script>
</body>
</html>