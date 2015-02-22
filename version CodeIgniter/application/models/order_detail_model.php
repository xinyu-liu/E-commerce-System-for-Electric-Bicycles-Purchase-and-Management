<?php
class Order_detail_model extends CI_Model{
	public function __construct(){
		$this->load->database();
	}

	public function get_order_details($orderID){

		$sql='select * from OrderDetail,Product 
				where orderID='.$orderID.' 
				AND Product.productID=OrderDetail.productID';

		$query = $this->db->query($sql);
		if($query->num_rows()<1){
			die('Wrong get order details in db');
		}
		else{
			return $query->result_array();
		}
	}

	// add items in Cart table to OrderDetail table
	public function	add_order_details($orderID){
		$customerID = $this->session->userdata('customerID'); 

		// get all information in table Cart 
		$sql='SELECT * FROM Cart WHERE customerID='.$customerID;
		$query = $this->db->query($sql);

		foreach ($query->result_array() as $row){
			$isBad=0;
			// already get one row in table Cart
			
			// get original price & isSpecial
			$sql1='SELECT productPrice FROM Product WHERE productID='.$row['productID'];
			$query1 = $this->db->query($sql1);
			if ($query1->num_rows() < 1){
				die('Wrong original price');
			}
			$row1 = $query1->row_array();
			$originalPrice = $row1['productPrice'];
			
			$isSpecial = 0;
			if($row['productPrice']<$originalPrice ){
				$isSpecial = 1;
			}
			
			// add to OrderDetail table
			$sql1 = 'INSERT INTO OrderDetail
					(productID, productQuantity, productPrice, productTotalPrice, isSpecial, orderID) 
					VALUES 
					('.$row['productID'].', '.$row['productQuantity'].', '.$row['productPrice'].', '.
					   $row['productTotalPrice'].', '.$isSpecial.', '.$orderID.');';
			$this->db->query($sql1);
			if( $this->db->affected_rows()!=1 ){
				$isBad = 1;
			}
		}
		return $isBad;
	}		
}
?>