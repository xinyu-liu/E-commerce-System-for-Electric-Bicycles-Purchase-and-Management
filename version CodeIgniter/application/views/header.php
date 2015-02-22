<!doctype html>
<html>
<head>
<meta charset="UTF-8">

<style type="text/css">
a:link,a:visited{color:#000; text-decoration:underline; font-weight:bold; }　 
a:hover,a:active{color:#F00; text-decoration:underline; font-weight:bold; }
</style>

<title><?php echo $title;?> </title>
</head>


<body>
<?php
$username = $this->session->userdata('username');
if($username=='<>'){
	echo '<b>Welcome, guest!&nbsp;&nbsp;&nbsp;';
	
	echo '<a href="'.base_url().'index.php/product">Main Page</a>';
	echo '&nbsp;&nbsp;&nbsp;';
	
	echo '<a href="'.base_url().'index.php/product/view_special">Special Sale</a>';
	echo '&nbsp;&nbsp;&nbsp;';
	
	echo '<a href="'.base_url().'index.php/cart/view_cart">Shopping Cart</a>';
	echo '&nbsp;&nbsp;&nbsp;';	
	
	echo '<a href="'.base_url().'index.php/customer/login">Login</a>';

	echo '&nbsp;&nbsp;&nbsp;<a href="'.base_url().'index.php/customer/add_customer">Register</a><br/></b>';
	
}
else{
	echo '<b>Welcome, '.$username.'!&nbsp;&nbsp;&nbsp;';
	
	echo '<a href="'.base_url().'index.php/product">Main Page</a>';
	echo '&nbsp;&nbsp;&nbsp;';
	
	echo '<a href="'.base_url().'index.php/product/view_special">Special Sale</a>';
	echo '&nbsp;&nbsp;&nbsp;';
	
	echo '<a href="'.base_url().'index.php/cart/view_cart">Shopping Cart</a>';
	echo '&nbsp;&nbsp;&nbsp;';	
	
	echo '<a href="'.base_url().'index.php/order/view_order_summary">History Order</a>';
	echo '&nbsp;&nbsp;&nbsp;';	
	
	echo '<a href="'.base_url().'index.php/customer/modify_customer">Modify Profile</a>';
	echo '&nbsp;&nbsp;&nbsp;';
		
	echo '<a href="'.base_url().'index.php/customer/logout/">Log out</a><br/></b>';   
           
}

?>