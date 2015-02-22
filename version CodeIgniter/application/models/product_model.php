<?php
class Product_model extends CI_Model{
	public function __construct(){
		$this->load->database();
	}
	
	public function get_categories(){
		$query = $this->db->query("SELECT * FROM ProductCategory");
		return $query->result_array();
	}
	
	public function get_all_in_category($productCategoryID){
		$sql='SELECT * FROM Product,ProductCategory 
			   WHERE Product.productCategoryID="'.$productCategoryID.'" 
			   AND Product.productCategoryID=ProductCategory.productCategoryID;';
			   	
		$query = $this->db->query($sql);	
		return $query->result_array();
	}
	
	public function get_special($productID=false){
		if(!$productID){	// find all
			$sql='SELECT productID, min(specialPrice) AS specialPrice 
				FROM SpecialSale WHERE endDate>=CURDATE() 
				AND startDate<=CURDATE() 
				GROUP BY productID';
			$query = $this->db->query($sql);	
			return $query->result_array();	// productID and min price
		}
		else{	// find one
			$sql='SELECT min(specialPrice) AS specialPrice 
				FROM SpecialSale WHERE productID='.$productID.
				' AND endDate>=CURDATE() 
				AND startDate<=CURDATE()';
			$query = $this->db->query($sql);		
			if ($query->num_rows() > 0){
				$row = $query->row_array(); 
		   		return $row['specialPrice'];	// min price only
			}
			else{
				return -1;
			}	
		}

	}
	
	public function get_one_product($productID){
		$sql='SELECT * FROM Product WHERE productID = '.$productID;
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0){
		   return $query->row_array(); 
		}
		else{
			die('Cannot find this product');
		}
	}
}
?>