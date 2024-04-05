<?php
session_start();
$admin_login_id = $_SESSION['admin_login_id'];
include_once '../_class/query.php';
include_once '../Activity_log/add_activity_log.php';
$obj = new query();
date_default_timezone_set('Asia/Dubai');

 

$date = date('d-m-Y');
$time = date('h:i:s A');
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
$file_name=$_FILES['file_upload']['name'];
if(isset($_FILES['file_upload'])){
	$dir='uploads/';
	$file_name=$_FILES['file_upload']['name'];
	$size=$_FILES['file_upload']['size'];
	$tmp_file_name=$_FILES['file_upload']['tmp_name'];
	 //echo $tmp_file_name.'<br>';
	 //echo $file_name.'<br>';
	 //echo $size;
		
	if(move_uploaded_file($tmp_file_name,$dir.$file_name)){
	//echo 'success<br>';
	include 'read_file.php';
	//assign_excel
	header("Location:lab.php");
	}

}else{
		
}	

?>