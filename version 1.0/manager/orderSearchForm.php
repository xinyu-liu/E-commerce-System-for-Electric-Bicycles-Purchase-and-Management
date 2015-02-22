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
<title>Orders Search</title>
</head>
<body>
<h2>Orders Search and View</h2>
<form method="post" action="orderSearchPHP.php">
<input type="button" value="Manager Main Page" onClick="toAdminMainPage()"/>

<table>
	<tr>
		<th>Product Name: </th>
        <td><input type="text" name="productName" maxlength="20"/></td>
        <td>NOTE: <br/>   % is a substitute for zero or more characters <br/>
							_ is a	substitute for a single character</td>         
   	</tr>
    <tr>
		<th>Product Category: </th>
<td>
<?php
$con=mysql_connect('localhost','lxy','1320');
if(!$con){
	die ('Could not connect to database'.mysql_error() );
}
mysql_select_db('company571',$con);
//////// for radio button value ////////////////
$sql2="select productCategoryName from productCategory";
$res2=mysql_query($sql2);
	
while($row2=mysql_fetch_array($res2)){
	echo  '<input type="radio" name="productCategory" value="'. $row2[0]. '" >'.  $row2[0].'</input><br/>'; 
}
?>
			<input type="radio" name="productCategory" value='All'>All</input>
        </td> 
   	</tr> 
    <tr>
		<th>Special Products?  </th>
        <td> <input type="radio" name="isSpecial" value="Y"> Yes </input>&nbsp;&nbsp;&nbsp;
       		  <input type="radio" name="isSpecial" value="N"> No </input>&nbsp;&nbsp;&nbsp;
       		  <input type="radio" name="isSpecial" value="A"> All </input>
        </td>
   	</tr>
    <tr>
		<th>Order Start Date (Inclusive)<br />(YYYY-MM-DD): </th>
        <td><input type="text" name="startDate" maxlength="10"  onChange="checkDateStart()" /></td>
   	</tr>
	<tr>
		<th>Order End Date (Exclusive)<br />(YYYY-MM-DD): </th>
        <td><input type="text" name="endDate" maxlength="10" onChange="checkDateEnd()" /></td>
   	</tr>
    <tr><td><input type="submit" value="Search"></td></tr>
</table>

</form>
<br/><br/><br/><br/>
<div id="result"><b>Product Search Result will be shown here.</b></div>
<script>
function checkDateStart()
{
	var a=document.f.startDate.value;
	var pattern=/^(\d{4})-(\d{2})-(\d{2})$/;
	var valid=a.match(pattern);
	var b=Date.parse(a);
	d=new Date(a);// start date
	if(valid)
	{
		if(document.f.endDate.value!=""){
			var e=new Date(document.f.endDate.value); //end date
		}
		if(isNaN(b)|| (document.f.endDate.value!=""&&e<d) )
		{
			alert("Please input a valid date");
			document.f.startDate.value="";
		}
	}
	else
	{	
		alert("Please follow date format");
		document.f.startDate.value="";
	}
}

function checkDateEnd()
{
	var a=document.f.endDate.value;
	var pattern=/^(\d{4})-(\d{2})-(\d{2})$/;
	var valid=a.match(pattern);
	var b=Date.parse(a);
	var e=new Date(a); //end date
	if(valid)
	{
			if(document.f.startDate.value!=""){
			var d=new Date(document.f.startDate.value); //start date
		}
		
		if(isNaN(b) || (document.f.startDate.value!=""&&e<=d))
		{
			alert("Please input a valid date");
			document.f.endDate.value="";
			return;
		}
		return true;
	}
	else
	{	
		alert("Please follow date format");
		document.f.endDate.value="";
		return;
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