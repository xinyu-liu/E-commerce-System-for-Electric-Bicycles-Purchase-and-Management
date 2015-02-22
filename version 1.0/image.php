<?php


echo "Type: " . $_FILES["file"]["type"] . "<br />";

if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 50000))// <50kb
{
  	if ($_FILES["file"]["error"] > 0){
   		echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  	else{
    	echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    	echo "Type: " . $_FILES["file"]["type"] . "<br />";
    	echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    	echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
		// store extension name
		$dot = strrpos($_FILES["file"]["name"],'.');
		$ext =  substr($_FILES["file"]["name"],$dot);// including dot
		
		// find image name num
		$sql="select * from CurrentImageNum";
		$con = mysql_connect('localhost','lxy','1320');
		if(!$con){
			die ('Could not connect to database'.mysql_error() );
		}
		mysql_select_db('company571',$con);
		$res = mysql_query($sql);
		if(!$row=mysql_fetch_array($res) ) {
			die('Wrong CurrentImageNum table');
		}
		
		$name = $row[0].$ext;
		if (file_exists("/hw2/upload/" . $name)){
			echo $name . " already exists. ";
		}
		else{
			move_uploaded_file($_FILES["file"]["tmp_name"], "upload/".$name);
			echo "Stored in: " . "/hw2/upload/" . $name;
			// increment num in db
			$num  = $row[0]+1;
			$sql = 'UPDATE CurrentImageNum SET num= '.$num;
			$res = mysql_query($sql);
			if(!$res) {
				die('Cannot update CurrentImageNum table');
			}
		}
	}
}
else{
	echo "Invalid file";
}

mysql_close($con);
?>
