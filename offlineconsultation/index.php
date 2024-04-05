<?php
session_start();
if(isset($_SESSION['doctor_login_id']) and $_SESSION['doctor_role'] == 'doctor'){
	header("Location:doctor/index.php");
}else if(isset($_SESSION['staff_login_id']) and $_SESSION['staff_role'] == 'staff'){
	header("Location:staff/index.php");
}else if(isset($_SESSION['admin_login_id']) and $_SESSION['admin_role'] == 'admin'){
	header("Location:admin/index.php");
}else{
	header("Location:login.php");
}
?>