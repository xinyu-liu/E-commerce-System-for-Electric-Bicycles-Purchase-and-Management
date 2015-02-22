<?php
class Customer_model extends CI_Model{
	public function __construct(){
		$this->load->database();
	}
	
	public function validate_customer($username,$password){
		$sql="select customerID from Customer where username='$username' and password=password('$password')";	
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row['customerID'];
	}

	public function get_one_customer_info($customerID){
		$sql='SELECT * FROM Customer WHERE customerID = '.$customerID;
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0){
		   return $query->row_array(); 
		}
		else{
			die('Invalid customerID');
		}
	}

	public function add_customer(){
		// deal with phone when add
		$phone='';
		if( filter_var($_POST['phone1'],FILTER_SANITIZE_STRING) && 
			filter_var($_POST['phone2'],FILTER_SANITIZE_STRING) && 
			filter_var($_POST['phone3'],FILTER_SANITIZE_STRING) ){
			$isPhone=true;
			$b = filter_var(  $_POST['phone1'],FILTER_VALIDATE_REGEXP,array( "options"=>array("regexp"=>"/^[1-9]+\d{2}$/") )  );
			$isPhone = $isPhone && $b;
				
			$b = filter_var(  $_POST['phone2'],FILTER_VALIDATE_REGEXP,array( "options"=>array("regexp"=>"/^\d{3}$/") )  );	
			$isPhone = $isPhone && $b;	
		
			$b = filter_var(  $_POST['phone3'],FILTER_VALIDATE_REGEXP,array( "options"=>array("regexp"=>"/^\d{4}$/") )  );	
			$isPhone = $isPhone && $b;	
				
			if($isPhone){
				$phone=$_POST['phone1'].'-'.$_POST['phone2'].'-'.$_POST['phone3'];
			}
		}
		$username = $this->input->post('username') ;
		$password = $this->input->post('password');
		$fname = $this->input->post('fname');	
		$lname = $this->input->post('lname');
		$email = $this->input->post('email');

		$sql="INSERT INTO Customer (username,password,firstName,lastName,phone,email) 
			VALUES ('".$username."',password('".$password."'),'".$fname."','".$lname."','".$phone."','".$email."') ";
		$ans = $this->db->query($sql); 
		return $ans;
	}
	
	public function modify_customer(){
		$customerID = $this->session->userdata('customerID') ;
		// deal with phone when add
		$phone='';
		if( filter_var($_POST['phone1'],FILTER_SANITIZE_STRING) && 
			filter_var($_POST['phone2'],FILTER_SANITIZE_STRING) && 
			filter_var($_POST['phone3'],FILTER_SANITIZE_STRING) ){
			$isPhone=true;
			$b = filter_var(  $_POST['phone1'],FILTER_VALIDATE_REGEXP,array( "options"=>array("regexp"=>"/^[1-9]+\d{2}$/") )  );
			$isPhone = $isPhone && $b;
				
			$b = filter_var(  $_POST['phone2'],FILTER_VALIDATE_REGEXP,array( "options"=>array("regexp"=>"/^\d{3}$/") )  );	
			$isPhone = $isPhone && $b;	
		
			$b = filter_var(  $_POST['phone3'],FILTER_VALIDATE_REGEXP,array( "options"=>array("regexp"=>"/^\d{4}$/") )  );	
			$isPhone = $isPhone && $b;	
				
			if($isPhone){
				$phone=$_POST['phone1'].'-'.$_POST['phone2'].'-'.$_POST['phone3'];
			}
		}
		$username = $this->input->post('username') ;
		$password = $this->input->post('password');
		$fname = $this->input->post('fname');	
		$lname = $this->input->post('lname');
		$email = $this->input->post('email');

		//modify
		$sql="UPDATE Customer 
				SET username='".$username.
				"',password=password('".$password."'),
				firstName='".$fname."',
				lastName='".$lname."',
				phone='".$phone."',
				email='".$email."' 
				WHERE customerID='".$customerID."'";

		$this->db->query($sql); 
		if(  $this->db->affected_rows()<1  ){
			echo '<script>alert("Error:Duplicate username");history.go(-1);</script>';
		}
		else{
			echo '<script>alert("One record modified"); </script>';
		}	
	}
}
?>