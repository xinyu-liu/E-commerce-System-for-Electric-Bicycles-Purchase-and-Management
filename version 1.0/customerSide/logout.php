<?php 
session_start(); 
session_destroy();
echo '<script>window.alert("You have logged out.");</script>';
echo "<script>window.location='productView.php';</script>";			
?>
