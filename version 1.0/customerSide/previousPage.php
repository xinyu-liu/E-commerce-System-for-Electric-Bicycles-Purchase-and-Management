<?php

$phpself=php_self();
$_SESSION['previousPage']=$phpself;
	
function php_self(){
    $php_self=substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1);
    return $php_self;
}

?>
