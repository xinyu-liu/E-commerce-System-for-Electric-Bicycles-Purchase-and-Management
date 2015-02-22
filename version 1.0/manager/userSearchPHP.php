<?php 
session_start(); 

if ($_SESSION['username']==null || $_SESSION['username']==''){
	session_destroy();
	echo '<script>window.alert("You have not logged in. Please re-login.");</script>';
	echo "<script>window.location='/hw2/login.php';</script>";
}
if($_SESSION['userType']!='manager'){
	session_destroy();
	echo '<script>window.alert("You have no permission of manager. Please re-login.");</script>';
	echo "<script>window.location='/hw2/login.php';</script>";
}
		
$thres = 5*60;//second
$t = time(); 
$diff = $t-$_SESSION['startTime'];
if ($diff>$thres) {
	session_destroy();
	echo '<script>window.alert("You have logged in for '.($thres/60).' minutes. Please re-login.");</script>';
	echo "<script>window.location='/hw2/login.php';</script>";
}				
?>


<?php
$lname = $_POST["lname"];
$minPay = $_POST["minPay"];
$maxPay = $_POST["maxPay"];
$userType = $_POST["type"];

// Connect to your database software
$con = mysql_connect('localhost','lxy','1320');
// check if connection fails
if(!$con){
	die ('Could not connect to database'.mysql_error() );
}
// Select a database
mysql_select_db('company571',$con);

$sql='select * from Users';
if($lname!='' || $minPay!='' || $maxPay!='' || $userType!='') {
	$sql.=' where';
	$where='';
	if($lname!='') {
		if($where!=''){
			$where.=' and';
		}
		if ( strpos($lname,'%') ==false && strpos($lname,'_') ==false ){
			$where=$where.' lastName ="'.$lname.'"';
		}
		else{	
			$where=$where.' lastName like"'.$lname.'"';
		}
	}
	if($minPay!='') {
		if($where!=''){
			$where.=' and';
		}
		$where=$where.' payment>="'.$minPay.'"';
	}
	if($maxPay!='') {
		if($where!=''){
			$where.=' and';
		}
		$where=$where.' payment<="'.$maxPay.'"';
	}
	if($userType!='') {
		if($where!=''){
			$where.=' and';
		}
		$where=$where.' userType="'.$userType.'"';
	}
	
	$sql.=$where;
}
$res = mysql_query($sql);

echo '<table><tr><th>Username</th><th>User Type</th><th>First Name</th><th>Last Name</th><th>Payment</th><th>Phone Number</th><th>Email</th></tr>';

while(   $row=mysql_fetch_assoc($res) ) {
	echo '<tr><td>'.$row['username'].'</td><td>'.$row['userType'].'</td><td>'.$row['firstName'].'</td><td>'.$row['lastName'].'</td><td>'.$row['payment'].'</td><td>'.$row['phone'].'</td><td>'.$row['email'].'</td></tr>';
}
echo '</table><br/>';


mysql_close($con);	

?>