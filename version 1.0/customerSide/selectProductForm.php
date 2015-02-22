<?php 
session_start(); 
require("sessionStart.php");
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Add Item To Cart</title>
</head>

<body>

<?php
$productID = $_GET['productID'];
$specialSaleID = $_GET['specialSaleID'];
$specialPrice = $_GET['specialPrice'];

	  
require('connectDB.php');

$sql1='SELECT * FROM Product WHERE productID = '.$productID;
$res1 = mysql_query($sql1);
$row1 = mysql_fetch_assoc($res1);
if(!$row1) {
	die('Wrong');
}
?>
<table cellpadding="10">
	<tr>
		<th colspan="2"><h1>Add Item To Cart</h1></th>
    </tr>
    <tr>
    	<td width="400" align="center"> 
        	<span style="font-size:18pt; font-weight:bold"><?php echo $row1['productName']; ?></span><br/>   
        	<?php echo $row1['productDescription']; ?><br/><br/>
           <form action="addToCart.php" method="post" onSubmit="return toValidate();">
           <table cellpadding="10">
           	<tr>
            		<th align="left" valign="top">Price:</th>
                  <td>
                  <?php 
				  		if ($specialSaleID>0){ echo '<s>';}
						echo '$'.$row1['productPrice'];
						$originalPrice=$row1['productPrice'];
						if ($specialSaleID>0){ 
							echo '</s>&nbsp;&nbsp;'; 
							echo $specialPrice;
							echo '<input type="hidden" name="productFinalPrice" value=" '.$specialPrice.'">';
						}
						else{
							echo '<input type="hidden" name="productFinalPrice" value=" '.$originalPrice.'">';
						}
					?>
					</td>
               </tr>
               <tr>
               	<th align="left" valign="top"> Quantity:</th>
                  <td>             
      <select name="quantity" id="ss2">
        <option value="">Choose one:</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
      </select>
      <br/><br/>If not exist, type in: 
      <input type="text" name="ss2add" id="add2" size="4" onChange="checkAndAddOption('add2','ss2')"/> <br/>
      then SELECT it in the list.

 <script>    
 function checkAndAddOption(id1,id2){
	t = document.getElementById(id1);
	reg = /^[0-9]*[1-9][0-9]*$/;　　
	if( t.value !="" && t.value.match(reg) ==null ) { // not a integer
		t.style.backgroundColor = "red";
		window.alert("Quantity should be an positive integer.\nPlease re-enter.");
		
	}
	else{
		t.style.backgroundColor = "white";
		addOption(id1,id2);
	}
}
function addOption(id1,id2){
	textElem = document.getElementById(id1);
	if(textElem.value !=""){			
		selectElem = document.getElementById(id2);
		//Create a new option element
		optionElem = document.createElement( "option" ); 
		//Set the text and value of the option element
		optionElem.text = textElem.value;
		optionElem.value = textElem.value;
		//Add the option element to the end of the select list
		selectElem.add( optionElem );
	}
}
</script>
                	</td>
               </tr>
            </table>
            	<br /><br />
               <input type="hidden" name="productID" value="<?php echo $productID; ?>">
           	 <input type="hidden" name="productName" value="<?php echo $row1['productName']; ?>">
            	<input type="submit" name='addMore' value="Add To Cart"/>		
            </form>
<script>
function isSelectChecked(elem,start){
	check = false;
	opts = elem.options;
	for(i=start;i<opts.length;i++){
		if(opts[i].selected){
			check= true;
		}
	}
	return check;	

}
function toValidate(){
	e = document.getElementById("ss2");		
	b=isSelectChecked(e,1); 	
	if (!b){
		alert("Quantity is required!");
		return false;
	}
	return true;
}
</script>            
       </td>
       		
    	<td width="250" align="center">
        
        <img src="../upload/<?php echo $row1['productImage']; ?>" width="250" height="250">
       </td>  
   </tr>
 </table>     

<?php	 
require('guessYouLike.php');
mysql_close($con);		
?>

</body>
</html>