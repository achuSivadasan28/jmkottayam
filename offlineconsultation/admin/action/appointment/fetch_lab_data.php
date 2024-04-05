<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
if(isset($_SESSION['admin_login_id'])){
$login_id = $_SESSION['admin_login_id'];
$admin_role = $_SESSION['admin_role'];
$admin_unique_code = $_SESSION['admin_unique_code'];
if($admin_role == 'admin'){
$api_key_value = $_SESSION['api_key_value'];
$admin_unique_code = $_SESSION['admin_unique_code'];
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$admin_unique_code);
	//echo $check_security;exit();
if($check_security == 1){
$response_arr = array();
$select_all_lab = $obj->selectData("test_name,mrp,special_rate","tbl_lab","where status!=0");
if(mysqli_num_rows($select_all_lab)>0){
	$x = 0;
	$response_arr[0]['status'] = 1;
	$response_arr[0]['data_exist'] = 1;
	while($select_all_lab_row = mysqli_fetch_array($select_all_lab)){
		$response_arr[$x]['test_name'] = $select_all_lab_row['test_name'];
		$response_arr[$x]['mrp'] = $select_all_lab_row['mrp'];
		$response_arr[$x]['special_rate'] = $select_all_lab_row['special_rate'];
		$x++;
	}
}else{
	$response_arr[0]['data_exist'] = 0;
}
}else{
	$response_arr[0]['status'] = 0;
}
}
}
echo json_encode($response_arr);
?>
