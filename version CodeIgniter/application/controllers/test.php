<?php
class Test extends CI_Controller {
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
		
		$this->load->helper('url');
  	}
  	public function index(){
  		redirect(site_url( $this->session->userdata('previousPage') ));
  	}
}
?>