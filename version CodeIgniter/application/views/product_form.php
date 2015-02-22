<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.0.js"></script>
<table cellpadding="10">
	<tr>
		<th colspan="2"><h1><?php echo $title;?></h1></th>
    </tr>
    <tr>
    	<td width="400" align="center"> 
        	<span style="font-size:18pt; font-weight:bold"><?php echo $thisProduct['productName']; ?></span><br/>   
        	<?php echo $thisProduct['productDescription']; ?><br/><br/>
            <form id="f" method="post" accept-charset="utf-8" 
            		action="<?php echo base_url().'index.php/cart/select/'.$thisProduct['productID'];?>" />         
           <table cellpadding="10">
           	<tr>
            		<th align="left" valign="top">Price:</th>
                  <td>
                  <?php 
				  		if ($specialPrice>-1){ echo '<s>';}
						echo '$'.sprintf('%.2f',$thisProduct['productPrice']);
						$originalPrice = $thisProduct['productPrice'];
						if ($specialPrice>-1){ 
							echo '</s>&nbsp;&nbsp;$'; 
							echo sprintf('%.2f',$specialPrice);
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
      <input type="text" name="ss2add" id="add2" size="4"/> <br/>
      then SELECT it in the list.

 <script>    
 $(document).ready(docReady);
 function docReady(){
 	$("#add2").change(checkAndAddOption);
 	$("#f").submit(toValidate);
 }
 function checkAndAddOption(){
 $("#add2").val();
	v =  $("#add2").val();
	reg = /^[0-9]*[1-9][0-9]*$/;　　
	if( v !="" && v.match(reg) ==null ) { // not a integer
		$("#add2").val("");	
		window.alert("Quantity should be an positive integer.\nPlease re-enter.");
		
	}
	else{
		addOption('add2','ss2');
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
               <input type="hidden" name="productID" value="<?php echo $thisProduct['productID']; ?>">
           	 <input type="hidden" name="productName" value="<?php echo $thisProduct['productName']; ?>">
            	<?php echo validation_errors(); ?>

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
        
        <img src="<?php echo base_url().'upload/'.$thisProduct['productImage']; ?>" width="250" height="250">
       </td>  
   </tr>
 </table>  