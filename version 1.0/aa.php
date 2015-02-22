<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
<?php 
// Connect to your database software
$con = mysql_connect('localhost','lxy','1320');
// check if connection fails
if(!$con){
	die ('Could not connect to database'.mysql_error() );
}
// Select a database
mysql_select_db('company571',$con);
// If your SQL was a SELECT
$res = mysql_query($sql);


while(   $row=mysql_fetch_assoc($res) ) {
     echo 'username '.$row['username'].
               'password '.$row['password'];

}

// At the end of your PHP script
mysql_close($con);
?>

</body>
</html>