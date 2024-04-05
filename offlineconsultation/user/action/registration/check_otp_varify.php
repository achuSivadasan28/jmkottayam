<?php
session_start();
if(isset($_SESSION['otp_varify'])){
if($_SESSION['otp_varify'] == 'success'){
	echo $_SESSION['phn_number'];
}else if($_SESSION['otp_varify'] == 'error'){
	echo 0;
}
}else{
	echo 0;
}
?>