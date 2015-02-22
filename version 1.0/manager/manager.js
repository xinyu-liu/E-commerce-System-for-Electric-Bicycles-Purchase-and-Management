xmlhttp;
function getXmlHttpObject(){
  xmlhttp=null;
  try{
     // Firefox, Opera 8.0+, Safari
     xmlhttp=new XMLHttpRequest();
   }
  catch (e){
   //Internet Explorer
     try{
	    xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
   	  }
     catch (e){
	    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
  }
  return xmlhttp;
}

function stateChanged() {  // call back function 
	if (xmlhttp.readyState==4 || xmlhttp.readyState==200){ 
 		document.getElementById("result").innerHTML=xmlhttp.responseText 
	} 
	else if (xmlhttp.readyState==400){
		 window.alert("Ready State 400 - script error");  
	}
	else if (xmlhttp.readyState==500){
		 window.alert("Ready State 500 - server error");  
	}
}
function showProduct(){
	//
	xmlhttp=getXmlHttpObject();
	if(xmlhttp==null){
		alert("Browser does not support HTTP Request.");
		return;
	}
	//
	var f = document.getElementById("pform");
	var data="productName=";
	data+=f.productName.value;
	data+="&minPrice=";
	data+=f.minPrice.value;
	data+="&maxPrice=";
	data+=f.maxPrice.value;
	data+="&productCategory=";
	for(i=0;i<f.productCategory.length;i++){
		if(f.productCategory[i].checked){
			data+=f.productCategory[i].value;
		}
	}	
	xmlhttp.onreadystatechange=stateChanged;
	// For POST request
	xmlhttp.open('POST','productSearchPHP.php', true);

	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');

	xmlhttp.send(data);
}
function showUser(){
	//
	xmlhttp=getXmlHttpObject();
	if(xmlhttp==null){
		alert("Browser does not support HTTP Request.");
		return;
	}
	//	
	var f = document.getElementById("uform");
	var data="lname=";
	data+=f.lname.value;
	data+="&minPay=";
	data+=f.minPay.value;
	data+="&maxPay=";
	data+=f.maxPay.value;
	data+="&type=";
	for(i=0;i<f.type.length;i++){
		if(f.type[i].checked){
			data+=f.type[i].value;
		}
	}	
	xmlhttp.onreadystatechange=stateChanged;
	// For POST request
	xmlhttp.open('POST','userSearchPHP.php', true);

	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');

	xmlhttp.send(data);
}
function showSpecial(){
	//
	xmlhttp=getXmlHttpObject();
	if(xmlhttp==null){
		alert("Browser does not support HTTP Request.");
		return;
	}
	//
	var f = document.getElementById("sform");
	var data="productName=";
	data+=f.productName.value;
	
	data+="&minPrice=";
	data+=f.minPrice.value;
	data+="&maxPrice=";
	data+=f.maxPrice.value;
	
	data+="&startDate=";
	data+=f.startDate.value;
	data+="&endDate=";
	data+=f.endDate.value;
	
	data+="&productCategory=";
	for(i=0;i<f.productCategory.length;i++){
		if(f.productCategory[i].checked){
			data+=f.productCategory[i].value;
		}
	}	
	xmlhttp.onreadystatechange=stateChanged;
	// For POST request
	xmlhttp.open('POST','specialSearchPHP.php', true);

	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');

	xmlhttp.send(data);
}
function showOrders(){
	//
	xmlhttp=getXmlHttpObject();
	if(xmlhttp==null){
		alert("Browser does not support HTTP Request.");
		return;
	}
	//
	var f = document.getElementById("oform");
	var data="productName=";
	data+=f.productName.value;
	
	data+="&startDate=";
	data+=f.startDate.value;
	data+="&endDate=";
	data+=f.endDate.value;
	
	data+="&productCategory=";
	for(i=0;i<f.productCategory.length;i++){
		if(f.productCategory[i].checked){
			data+=f.productCategory[i].value;
		}
	}	
		
	data+="&isSpecial=";
	for(i=0;i<f.isSpecial.length;i++){
		if(f.isSpecial[i].checked){
			data+=f.isSpecial[i].value;
		}
	}
		
	xmlhttp.onreadystatechange=stateChanged;
	// For POST request
	xmlhttp.open('POST','orderSearchPHP.php', true);

	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');

	xmlhttp.send(data);
}
