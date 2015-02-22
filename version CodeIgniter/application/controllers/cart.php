<?php
class Cart extends CI_Controller {
	
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
		
		$this->load->model('product_model');
    	$this->load->model('cart_model');
		$this->load->helper('url');
  	}
  
  	public function select($productID){
		$data['title'] = 'Add Item To Cart';
		$specialPrice = $this->product_model->get_special($productID);
		$data['specialPrice']=$specialPrice;
     	$data['thisProduct'] = $this->product_model->get_one_product($productID);
				
		$this->load->helper('form');
  		$this->load->library('form_validation');
  		
		//  set_rules() 方法包含三个参数，
		// 第一个是输入域的名称，第二个是错误信息的名称，
		// 第三个是错误信息的规则——在这里的规则是输入内容的文本域必填。
  		$this->form_validation->set_rules('quantity', 'Quantity', 'required|is_natural_no_zero');
  		
		// if not success, show form
		if ($this->form_validation->run() === FALSE){
  			$this->load->view('header', $data);
  			$this->load->view('product_form', $data);
  			$this->load->view('footer');
  		}
		// if success, call model, load success view。
  		else{
    		$this->cart_model->add_one_product();
    		redirect(site_url('cart/view_cart'));
			
  		}
	}
	
    public function view_cart(){
    	$this->session->set_userdata('previousPage', 'cart/view_cart');
	  	$data['title']='My Shopping Cart';
	    $this->load->view('header', $data);
  		$this->load->view('cart_view');
  		$this->load->view('footer');
	}
	
	public function delete_one_in_cart($cartID){
		$this->cart_model->delete_one_product($cartID);
	}
	
	public function delete_all_in_cart(){
		$this->cart_model->delete_all_products();
	}
	    
	public function check_out(){
		$username = $this->session->userdata('username');
		if($username=='<>'){
			if ( $this->session->userdata('numInCart') >0 ) {
				$this->session->set_userdata('previousPage', 'cart/check_out');
				redirect(site_url('customer/login'));	
				// finish add session to table
			}
		}
		else{
			redirect(site_url("order/order_form_info"));
		}
	}
	
}
?>
