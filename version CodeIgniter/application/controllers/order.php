<?php
class Order extends CI_Controller {
	public function __construct(){
    	parent::__construct();
		// session
		$this->load->library('session');
		$username = $this->session->userdata('username');
		if(!$username){
			echo "''".$username;
			$this->session->set_userdata('username', '<>');
			$this->session->set_userdata('numInCart', '0');
		}
					
		$this->load->model('cart_model');
    	$this->load->model('orders_model');
    	$this->load->model('order_detail_model');
    	$this->load->model('transaction_model');
		$this->load->helper('url');
  	}
  
  	public function view_order_summary(){
  		$this->session->set_userdata('previousPage', 'order/view_order_summary');
		$data['title'] = 'History Order Detail';
	    
		// get customer orders in order table
		$data['row_array'] = $this->orders_model->get_customer_orders();

  		$this->load->view('header', $data);
  		$this->load->view('order_summary_view', $data);
  		$this->load->view('footer');
  	}
  
  	public function view_order_detail($orderID){
		$data['title'] = 'History Order Detail';
	    
		// get one order in order table
		$data['row'] = $this->orders_model->get_one_order($orderID);
		// get order details for this order
		$data['row2_array'] = $this->order_detail_model->get_order_details($orderID);

  		$this->load->view('header', $data);
  		$this->load->view('order_detail_view', $data);
  		$this->load->view('footer');
  	}

	public function order_form_info(){
		$data['title'] = 'Order Form';
	
		$this->load->helper('form');
  		$this->load->library('form_validation');
  		 
  		$this->form_validation->set_rules('shippingName', 'Shipping Name', 'trim|required|max_length[30]|xss_clean');
		$this->form_validation->set_rules('shippingRoad', 'Shipping Road', 'trim|required||max_length[100]|xss_clean');
		$this->form_validation->set_rules('shippingCity', 'Shipping City', 'trim|required|max_length[20]|xss_clean');
		$this->form_validation->set_rules('shippingState', 'Shipping State', 'trim|required|alpha|max_length[2]|xss_clean');
		
		$this->form_validation->set_rules('shippingPhone1', 'Shipping Phone', 'trim|required|exact_length[3]|integer|greater_than[99]|less_than[1000]');
		$this->form_validation->set_rules('shippingPhone2', 'Shipping Phone', 'trim|required|exact_length[3]|integer|greater_than[-1]|less_than[1000]');
		$this->form_validation->set_rules('shippingPhone1', 'Shipping Phone', 'trim|required|exact_length[4]|integer|greater_than[-1]|less_than[10000]');

 		$this->form_validation->set_rules('creditCardNumber1', 'Credit Card Number', 'trim|required|exact_length[4]|integer|greater_than[-1]|less_than[10000]');
		$this->form_validation->set_rules('creditCardNumber2', 'Credit Card Number', 'trim|required|exact_length[4]|integer|greater_than[-1]|less_than[10000]');
		$this->form_validation->set_rules('creditCardNumber3', 'Credit Card Number', 'trim|required|exact_length[4]|integer|greater_than[-1]|less_than[10000]');
		$this->form_validation->set_rules('creditCardNumber4', 'Credit Card Number', 'trim|required|exact_length[4]|integer|greater_than[-1]|less_than[10000]');

		$this->form_validation->set_rules('creditCardPin', 'Shipping Phone', 'trim|required|exact_length[3]|integer|greater_than[-1]|less_than[1000]');

  		$this->form_validation->set_rules('billingName', 'Billing Name', 'trim|required|max_length[30]|xss_clean');
		$this->form_validation->set_rules('billingRoad', 'Billing Road', 'trim|required||max_length[100]|xss_clean');
		$this->form_validation->set_rules('billingCity', 'Billing City', 'trim|required|max_length[20]|xss_clean');
		$this->form_validation->set_rules('billingState', 'Billing State', 'trim|required|alpha|max_length[2]|xss_clean');

		// if not success, show form
		if ($this->form_validation->run() === FALSE){
  			$this->load->view('header', $data);
  			$this->load->view('order_form');
  			$this->load->view('footer');
  		}
		// if success, call model, load success view。
  		else{

    		$shippingPhone = $this->input->post('shippingPhone1') .'-'. 
							 $this->input->post('shippingPhone2') .'-'. 
							 $this->input->post('shippingPhone3');
			$creditCardNumber = $this->input->post('creditCardNumber1') .'-'.
								$this->input->post('creditCardNumber2') .'-'.
								$this->input->post('creditCardNumber3') .'-'.
								$this->input->post('creditCardNumber4');
			// get cartTotalPrice
	     	$cartTotalPrice = $this->cart_model->get_total_price_in_cart();
						
			$this->transaction_model->start_transaction();	

			$isBad = 0;
			// add to Orders table	
			$data['customerID'] = $this->session->userdata('customerID');
			$data['orderTotalPrice'] = $cartTotalPrice;
			$data['shippingName'] = $this->input->post('shippingName');
			$data['shippingRoad'] = $this->input->post('shippingRoad');
			$data['shippingCity'] = $this->input->post('shippingCity');
			$data['shippingState'] = $this->input->post('shippingState');
			$data['shippingPhone']=$shippingPhone;
			$data['creditCardNumber']=$creditCardNumber;
			$data['creditCardPin']=$this->input->post('creditCardPin');
			$data['billingName']=$this->input->post('billingName');
			$data['billingRoad']=$this->input->post('billingRoad');
			$data['billingCity']=$this->input->post('billingCity');
			$data['billingState']=$this->input->post('billingState');

			$isBad = $this->orders_model->add_an_order($data);
				

			// find orderID					
			$orderID = $this->orders_model->get_order_id();
			if($orderID == -1){
				$isBad=1;
			}
			
			// add to OrderDetail table
			if($this->order_detail_model->add_order_details($orderID)==1){
				$isBad = 1;
			}

			// delete rows in Cart table	
			if($this->cart_model->delete_rows_in_cart()==1){
				$isBad = 1;
			}	
			
			if($isBad == 1){
				$this->transaction_model->roll_back();	
			}	
			else{
				$this->transaction_model->commit();	
				
			}
			redirect(site_url('order/view_order_detail/'.$orderID));	
  		}
	}
}

?>

