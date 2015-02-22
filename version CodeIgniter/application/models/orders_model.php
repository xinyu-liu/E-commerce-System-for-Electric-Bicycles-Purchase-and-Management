<?php
class Orders_model extends CI_Model{
	public function __construct(){
		$this->load->database();
	}

	// find orderID
	public function get_order_id(){
		$orderID = -1;

		$sql = 'SELECT max(orderID) as maxID FROM Orders;'; 
		$query = $this->db->query($sql);
		$row = $query->row_array();

		if($query->num_rows()==1) {
			$orderID = $row['maxID'];
		}
		return $orderID;
	}
	
	public function get_one_order($orderID){
		$sql='select * from Orders where orderID='.$orderID;
		$query = $this->db->query($sql);
		if($query->num_rows()<1){
			die("Wrong get order details in db");
		}
		else{
			return $query->result_array();
		}
	}

	public function get_customer_orders(){
		$sql='select orderID, orderDate, orderTotalPrice, shippingName, shippingRoad, shippingCity, 
				shippingState from Orders 
				where customerID='.$this->session->userdata('customerID').' 
				ORDER BY orderDate DESC';
		$query = $this->db->query($sql);
		if($query->num_rows()<1){
			die("Wrong get customer orders in db");
		}
		else{
			return $query->result_array();
		}
	}
	// add to Orders table	
	public function add_an_order($data){
		$sql = 'INSERT INTO Orders(customerID, orderTotalPrice, orderDate, 
					shippingName, shippingRoad, shippingCity, shippingState, shippingPhone, 
					creditCardNumber, creditCardPin, 
					billingName, billingRoad, billingCity, billingState) 
				VALUES ('.$data['customerID'].','.$data['orderTotalPrice'].',NOW(),"'.

						$data['shippingName'].'","'.$data['shippingRoad'].'","'.$data['shippingCity'].'","'.
						$data['shippingState'].'","'.$data['shippingPhone'].'",

						"'.$data['creditCardNumber'].'",'.$data['creditCardPin'].',

						"'.$data['billingName'].'","'.$data['billingRoad'].'","'.$data['billingCity'].'","'.
						   $data['billingState'].'"	);';	
						
		$this->db->query($sql);
		if( $this->db->affected_rows()!=1 ){
			$isBad = 1;
			return $isBad;
		}
		else{
			return 0;
		}
	}
}
?>