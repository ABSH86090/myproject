<?php

$convar = $_POST['contentVar'];
$convar_new = "";
if(isset($convar) && $convar != ""){
	
	$convar_new = preg_replace("#[^0-9a-z@.]#i",'',$convar);
	$check_mail = filter_var($convar_new,FILTER_VALIDATE_EMAIL);
	include_once("connect.php");
	$query4 = "SELECT id FROM tmp_users WHERE uEmail = '$convar_new'";
	$result4 = mysqli_query($link,$query4);
    $count4 = mysqli_num_rows($result4);
	
	
	if($count4 > 0 || !$check_mail){
		echo '<img src="images/cross.png" ></img>  Email not available';
	}	
		
	else {
		echo "<img src='images/tick.png' ></img> Email is available";
		}	
	
	
}

?>