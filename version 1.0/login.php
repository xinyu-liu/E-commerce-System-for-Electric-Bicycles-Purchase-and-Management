<?php 
session_start(); 
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
// login.php
require 'prelogin.html';
require 'postlogin.html';

$username=$_POST['username'];
$password=$_POST['password'];
// echo $username.' '.$password.' '.strlen($username).' '.strlen($password);
$errmsg='';
if( strlen($username)==0 || strlen($password)==0 ) {
	$errmsg='Invalid login';
}
// first login, empty out error msg
if( strlen($username)==0 && strlen($password)==0 ) {
	$errmsg='';
}

// when both exist, validate to db
if( strlen($username)>0 && strlen($password)>0 ) {
	$sql="select userType from Users where username='$username' and password=password('$password')";
	
	// start DB connection
	$con=mysql_connect('localhost','lxy','1320');
	if(!$con){
		die ('Could not connect to database'.mysql_error() );
	}
	mysql_select_db('company571',$con);
	$res = mysql_query($sql); 
	if(  !( $row=mysql_fetch_array($res) )  ){
		$errmsg='Invalid login1';
	}

	// end DB connection
	mysql_close($con);
	
	// error case: missing un OR missing pw OR didn’t validate to db
	if( strlen($errmsg)>0 ){
		//require 'prelogin.html';
		echo "<p style='color:red'>$errmsg</p>";
		//require 'postlogin.html';
	}
	// no user name & no password
	elseif( !$res ) {
   		// $res is 0 if we didn’t talk to DB
     // 	require 'prelogin.html';
      //	require 'postlogin.html';
	}	
	else {
     	// valid username and password
     	// display appropriate page
			$userType=$row[0];
			if($userType=='admin'){
				// store data
				$_SESSION['startTime']=time();//returns the current server time 
				$_SESSION['userType']=$userType;
				$_SESSION['username']=$username;
				echo "<script>window.location='admin/admin.php';</script>";
			}
			elseif($userType=='manager'){
				$_SESSION['startTime']=time();//returns the current server time 
				$_SESSION['userType']=$userType;
				$_SESSION['username']=$username;
				echo "<script>window.location='manager/manager.php';</script>";
			}
			elseif($userType=='employee'){
				$_SESSION['startTime']=time();//returns the current server time 
				$_SESSION['userType']=$userType;
				$_SESSION['username']=$username;
				echo "<script>window.location='employee/employee.php';</script>";
			}
			else{
				session_destroy(); 
				die ('wrong type and system false');
			}
	} 
}
?>
</body>
</html>