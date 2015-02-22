<?php
class Customer extends CI_Controller {
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
    	$this->load->model('customer_model');
		$this->load->helper('url');
  	}

   	public function add_customer(){
		$data['title'] = 'Customer Form';

		$this->load->helper('form');
  		$this->load->library('form_validation');
  		
  		$this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[20]|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required||max_length[20]');
		$this->form_validation->set_rules('fname', 'First Name', 'trim|required|max_length[20]|xss_clean');
		$this->form_validation->set_rules('lname', 'Last Name', 'trim|required|max_length[20]|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
  		
		// if not success, show form
		if ($this->form_validation->run() === FALSE){
			$this->load->view('header', $data);
	  		$this->load->view('customer_form', $data);
	  		$this->load->view('footer');
  		}
		// if success, call model, load success view。
  		else{
    		$ans = $this->customer_model->add_customer();
    		if(  !$ans ){
				echo '<script>alert("Error:Duplicate username");history.go(-1);</script>';
			}
			else{
				echo '<script>alert("One record added"); </script>';
				redirect(site_url('customer/login'));
			}		
  		}
  	}

  	public function modify_customer(){
		$data['title'] = 'Customer Form';
		// for filled in form 
		$customerID = $this->session->userdata('customerID');
		$data['row'] = $this->customer_model->get_one_customer_info($customerID);

		$this->load->helper('form');
  		$this->load->library('form_validation');
  		
  		$this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[20]|xss_clean');
		$this->form_validation->set_rules('fname', 'First Name', 'trim|required|max_length[20]|xss_clean');
		$this->form_validation->set_rules('lname', 'Last Name', 'trim|required|max_length[20]|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
  		
		// if not success, show form
		if ($this->form_validation->run() === FALSE){
			$this->load->view('header', $data);
	  		$this->load->view('customer_form', $data);
	  		$this->load->view('footer');
  		}
		// if success, call model, load success view。
  		else{
    		$this->customer_model->modify_customer();
    		redirect(site_url( $this->session->userdata('previousPage') ));
			
  		}

  	}

  	public function logout(){
  		$this->session->sess_destroy();
		echo '<script>alert("You have logged out.");</script>';			
		redirect(site_url('product'));
  	}

  	public function login(){
		error_reporting(E_ALL^E_NOTICE^E_WARNING);
		  
		$username = $this->session->userdata('username');
		if($username=='<>'){ // not login yet
			$username=$this->input->post('username');
			$password=$this->input->post('password');
		
			$errmsg='';
			if( strlen($username)==0 || strlen($password)==0 ) {
				$errmsg='Invalid login';
			}
			// first login, empty out error msg
			if( strlen($username)==0 && strlen($password)==0 ) {
				$errmsg='';
				$data['title'] = 'Login';
				$this->load->view('header', $data);
	  			$this->load->view('login.html');
	  			$this->load->view('footer');
			}
			
			// when both exist, validate to db
			if( strlen($username)>0 || strlen($password)>0 ) {
				$customerID = $this->customer_model->validate_customer($username,$password); 
				if( !$customerID ){
					$errmsg='Invalid login';
				}	
			
				// error case: missing un OR missing pw OR didn’t validate to db
				if( strlen($errmsg)>0 ){
					echo "<p style='color:red'>$errmsg</p>";
					$data['title'] = 'Login';
					$this->load->view('header', $data);
	  				$this->load->view('login.html');
	  				$this->load->view('footer');
				}
				// no user name & no password
				elseif( !$customerID ) {
					// $res is 0 if we didn’t talk to DB
					$data['title'] = 'Login';
					$this->load->view('header', $data);
	  				$this->load->view('login.html');
	  				$this->load->view('footer');
				}	
				else {
					// valid username and password, display appropriate page
					
					// $_SESSION['startTime']=time();//returns the current server time 		
					$this->session->set_userdata('customerID', $customerID);
					$this->session->set_userdata('username', $username);
						
					// store All Session Into DB			
					$this->cart_model->store_session_to_db();
					redirect(site_url( $this->session->userdata('previousPage') ));
				} 
			}
		}
		else{ // have login before
			echo 'You have logged in as '.$this->session->userdata('username');
					
			echo '<form method="post" accept-charset="utf-8" 
	            		action="'.base_url().'index.php/customer/logout/" /> ';        
	           
			echo '	<input type="button" value="Back" onClick="toGoBack()"/>';
			echo '	<input type="submit" name="logout" value="Logout" />';
			echo '</form>';
			
		}
  	}
}
?>
<script>
	function toGoBack(){
		history.go(-1);
	}
</script>