<?php 
session_start(); 
require("sessionStart.php");

// start DB connection
require('connectDB.php');
?>

<?php
$customerID = $_SESSION['customerID']; 
$sql='DELETE FROM Customer WHERE customerID='.$customerID.';';
if (!mysql_query($sql,$con)){
		die('Error: ' . mysql_error());
}

echo '<script>alert("Customer record(s) deleted"); window.location="logout.php";</script>';
mysql_close($con);
?>
</body>
</html>