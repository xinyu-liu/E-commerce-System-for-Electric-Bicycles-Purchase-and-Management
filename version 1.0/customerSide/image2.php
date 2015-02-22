<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
<img src='/hw2/upload/1.jpg'>
<?php
$normImageSize = 250; /////

$image_file   =   '../upload/0.png'; 
$image_size   =   getimagesize($image_file); 
if($image_size[0]<$image_size[1]){ // width<height
	$height=$normImageSize;
	$width=floor($normImageSize/$image_size[1]*$image_size[0]);
}
else{ // width>height
	$width=$normImageSize;
	$height=floor($normImageSize/$image_size[0]*$image_size[1]);
}
print( "图片的宽度： ".   $image_size[0]. " <br> "); 
print( "图片的高度： ".   $image_size[1]. " <br> "); 
print( "文件的格式为： ".   $image_size[2]. " <br> ");
//<img src="$image_file" width="50" height="50">
echo '<img src="'.$image_file.'" width="'.$width.'" height="'.$height.'">';
echo $width.'  '.$height;
?>

</body>
</html>
