<?php
class Product extends CI_Controller {
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
		$this->load->helper('url');
  	}
  
 	 // view all
  	public function index(){
  		$this->session->set_userdata('previousPage', 'product');
		$data['title'] = 'Products';
	    
		// find categories
     	$data['categories'] = $this->product_model->get_categories();
		
		// find product in each category
		$num=0;
	 	foreach ($data['categories'] as $row){
			$temp='c_'.$num;
			$data[$temp] = $this->product_model->get_all_in_category($row['productCategoryID']);			
			$num++;
		}
		// find current special product
     	$data['special'] = $this->product_model->get_special();		
				
  		$this->load->view('header', $data);
  		$this->load->view('product_view', $data);
  		$this->load->view('footer');
  }
  
  	public function view_special(){
	  	$this->session->set_userdata('previousPage', 'product/view_special');
		$data['title'] = 'Special Sale';
	    
		// find categories
     	$data['categories'] = $this->product_model->get_categories();
		
		// find product in each category
		$num=0;
	 	foreach ($data['categories'] as $row){
			$temp='c_'.$num;
			$data[$temp] = $this->product_model->get_all_in_category($row['productCategoryID']);			
			$num++;
		}
		// find current special product
     	$data['special'] = $this->product_model->get_special();		
				
  		$this->load->view('header', $data);
  		$this->load->view('special_view', $data);
  		$this->load->view('footer');
  	}	
}
?>
