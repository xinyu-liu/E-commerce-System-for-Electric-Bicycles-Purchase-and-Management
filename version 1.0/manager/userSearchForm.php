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


<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>User Search</title>
<script src="manager.js"></script>
</head>
<body>
<h2>User Search and View</h2>
<form id="uform" name="f">
<input type="button" value="Manager Main Page" onClick="toAdminMainPage()"/>

<table>
	<tr>
		<th>Last Name: </th>
        <td><input type="text" name="lname" maxlength="20"/></td>
        <td>NOTE: <br/>   % is a substitute for zero or more characters <br/>
							_ is a	substitute for a single character</td>         
   	</tr>
	<tr>
		<th> Lowest Pay Range: </th>
        <td><input type="text" name="minPay" maxlength="20" onChange="checkMinPay()"/></td>
   	</tr>
	<tr>
		<th>Highest Pay Range: </th>
        <td><input type="text" name="maxPay" maxlength="20" onChange="checkMaxPay()" /></td>
   	</tr>
    <tr>
		<th>Type of Employee: </th>
		<td><input type="radio" name="type" value="employee" >Employee</input><br/>
           <input type="radio" name="type" value="manager" >Manager</input><br/>
           <input type="radio" name="type" value="admin" >Administrator</input><br/> 
   	  	</td> 
   	</tr>  
    <tr><td><input type="button" value="Search" onClick="showUser()"></td></tr>
</table>

</form>
<br/><br/><br/><br/>
<div id="result"><b>Employee Search Result will be shown here.</b></div>
<script>
function checkMinPay()
{
	var pattern=/^(\d*\.)?\d+$/;
	var a = document.f.minPay.value; 
	if(a!="" && !a.match(pattern))
	{
	 	alert("Please input a valid payment");
		document.f.minPay.value="";
	}
	if(document.f.maxPay.value!="" && document.f.minPay.value>document.f.maxPay.value){
	 	alert("The min payment should be smaller than or equal to the max payment.");
		document.f.minPay.value="";
	}
}
function checkMaxPay()
{
	var pattern=/^(\d*\.)?\d+$/;
	var a = document.f.maxPay.value; 
	if(a!="" && !a.match(pattern)){
	 	alert("Please input a valid payment");
		document.f.maxPay.value="";
	}
	if(document.f.minPay.value!="" && document.f.minPay.value>document.f.maxPay.value){
	 	alert("The max payment should be larger than or equal to the min payment.");
		document.f.maxPay.value="";
	}
}
</script>
<script>
function toAdminMainPage(){
	window.location='manager.php';
}
</script>
</body>

</html>