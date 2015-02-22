<?php
class Cart_model extends CI_Model{
	public function __construct(){
		$this->load->database();
		// 通过 $this->db 对象就可以使用数据库类了。
	}
	
	public function view_cart(){
		$username = $this->session->userdata('username');
		if($username=='<>'){
			// Must use Session variables Until they login.
			$numInCart = $this->session->userdata('numInCart');
			$numInCart++;	
			$this->session->set_userdata('numInCart', $numInCart);

			$cur = 'p'.$numInCart.'_ID';
			$this->session->set_userdata($cur, $this->input->post('productID'));
			
			$cur = 'p'.$numInCart.'_name';
			$this->session->set_userdata($cur, $this->input->post('productName'));
			
			$cur = 'p'.$numInCart.'_price';
			$this->session->set_userdata($cur, $this->input->post('productFinalPrice'));
			
			$cur = 'p'.$numInCart.'_quantity';	
			$this->session->set_userdata($cur, $this->input->post('quantity'));
	
		}
		else{ 
			$customerID = $this->session->userdata('customerID') ;
			$productID = $this->input->post('productID');
			$productPrice = $this->input->post('productFinalPrice');	
			$productQuantity = $this->input->post('quantity');
			$productTotalPrice = 	$productPrice * $productQuantity;
		
			$sql='INSERT INTO Cart(productID, productQuantity, productPrice, productTotalPrice, customerID) 
				VALUES ('.$productID.', '.$productQuantity.', '.$productPrice.', '.$productTotalPrice.', '.$customerID.');';
							
			$this->db->query($sql); 
			if(  $this->db->affected_rows()<1  ){
				die('Invalid insert into database cart');
			}
		}
	}
		public function add_one_product(){
		$username = $this->session->userdata('username');
		if($username=='<>'){
			// Must use Session variables Until they login.
			$numInCart = $this->session->userdata('numInCart');
			echo $numInCart;
			$numInCart++;	
			echo $numInCart;
			$this->session->set_userdata('numInCart', $numInCart);

			$cur = 'p'.$numInCart.'_ID';
			$this->session->set_userdata($cur, $this->input->post('productID'));
			
			$cur = 'p'.$numInCart.'_name';
			$this->session->set_userdata($cur, $this->input->post('productName'));
			
			$cur = 'p'.$numInCart.'_price';
			$this->session->set_userdata($cur, $this->input->post('productFinalPrice'));
			
			$cur = 'p'.$numInCart.'_quantity';	
			$this->session->set_userdata($cur, $this->input->post('quantity'));
	
		}
		else{ 
			$customerID = $this->session->userdata('customerID') ;
			$productID = $this->input->post('productID');
			$productPrice = $this->input->post('productFinalPrice');	
			$productQuantity = $this->input->post('quantity');
			$productTotalPrice = 	$productPrice * $productQuantity;
		
			$sql='INSERT INTO Cart(productID, productQuantity, productPrice, productTotalPrice, customerID) 
				VALUES ('.$productID.', '.$productQuantity.', '.$productPrice.', '.$productTotalPrice.', '.$customerID.');';
							
			$ans = $this->db->query($sql); 
			if(!$ans){
				die('Invalid insert into database cart');
			}
		}
	}
	
	public function delete_one_product($cartID){
		$username = $this->session->userdata('username');
		if($username=='<>'){
			$cur = 'p'.$cartID.'_ID';
			$this->session->set_userdata($cur, '-1'); // marked as deleted
		}
		else{
			$sql='DELETE FROM Cart WHERE cartID= '.$cartID.';';
			$this->db->query($sql);
			if( $this->db->affected_rows()!=1 ){
				die('Invalid delete one item in table cart');
			}
		}
		$this->session->set_userdata('previousPage', 'index.php/cart/view_cart');
		redirect(site_url('cart/view_cart'));
	}
	
	public function delete_all_products(){
		$username = $this->session->userdata('username');
		if($username=='<>'){
			for( $i=1; $i <= $this->session->userdata('numInCart') ; $i++ ){
				$cur = 'p'.$i.'_ID';
				$this->session->unset_userdata($cur);
				
				$cur = 'p'.$i.'_name';
				$this->session->unset_userdata($cur);
				
				$cur = 'p'.$i.'_price';	
				$this->session->unset_userdata($cur);
						
				$cur = 'p'.$i.'_quantity';		
				$this->session->unset_userdata($cur);
			}
			$this->session->set_userdata('numInCart', '0'); 
		}
		else{	
			$sql='DELETE FROM Cart WHERE customerID= '.$this->session->userdata('customerID').';';		
			$this->db->query($sql);
		}
		$this->session->set_userdata('previousPage', 'index.php/cart/view_cart');
		redirect(site_url('cart/view_cart'));	
	}

	public function store_session_to_db(){
		for( $i=1; $i<=$this->session->userdata('numInCart') ; $i++ ){
			$cur = 'p'.$i.'_name';
			$this->session->unset_userdata($cur);	
											
			$cur = 'p'.$i.'_ID';
			$productID = $this->session->userdata($cur); //
			$this->session->unset_userdata($cur);
				
			$cur = 'p'.$i.'_price';	
			$productPrice = $this->session->userdata($cur); //
			$this->session->unset_userdata($cur);
							
			$cur = 'p'.$i.'_quantity';	
			$productQuantity = $this->session->userdata($cur); //
			$productTotalPrice = $productPrice * $productQuantity;
			$this->session->unset_userdata($cur);
					
			$sql='INSERT INTO Cart(productID, productQuantity, productPrice, productTotalPrice, customerID) 
					VALUES ('.$productID.', '.$productQuantity.', '.$productPrice.',  '.$productTotalPrice.', '.$this->session->userdata('customerID').');';
						
			$this->db->query($sql);
			if( $this->db->affected_rows()!=1 ){
				die('Invalid INSERT one session item in table cart');
			}
		}
		$this->session->unset_userdata('numInCart');
	}
	public function get_total_price_in_cart(){
		$sql='SELECT sum(productTotalPrice) as cartTotalPrice FROM Cart 
				WHERE customerID='.$this->session->userdata('customerID');	
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0){
			$row = $query->row_array();
		   	return $row['cartTotalPrice'];
		}
		else{
			die('Cannot find cart for this customer');
		}
	}

	// delete rows in Cart table
	public function delete_rows_in_cart(){
		$sql='DELETE FROM Cart
				WHERE customerID='.$this->session->userdata('customerID');	
		$this->db->query($sql);
		if ($this->db->affected_rows() > 0){
		   	return 0;
		}
		else{
			$isBad =1;
			return $isBad;
		}
	}
}

?>