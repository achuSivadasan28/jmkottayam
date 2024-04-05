<?php
session_start();
if(isset($_SESSION['otp'])){
	$otp = $_POST['otp'];
	if($otp == $_SESSION['otp']){
		$_SESSION['otp_varify'] = 'success';
		echo 1;
	}else{
		echo 2;
		$_SESSION['otp_varify'] = 'error';
	}
}else{
	echo 0;
	$_SESSION['otp_varify'] = 'error';
}
?>