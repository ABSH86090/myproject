<?php

$phone =  $_POST['phone'];
$phone_new = "";
if(isset($phone) && $phone != ""){
	
	$phone_new = preg_replace("#[^0-9]#i",'',$phone);

	
	
	if(strlen($phone_new) != 10){
		echo '<img src="images/cross.png" ></img>  Enter a 10-digit phone number';
		}		
	
}

?>