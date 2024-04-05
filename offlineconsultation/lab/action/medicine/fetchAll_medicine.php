<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
require_once '../../../_class_billing/query1.php';
echo "haii";exit();
include_once '../SMS/sendsms.php';
$response_arr = array();
$obj=new query();
$obj_bill=new query1();

date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$c_days=date('Y-m-d');
$times=date('h:i:s A');
$c_year = date('Y');
if(isset($_SESSION['nurse_login_id'])){
$login_id = $_SESSION['nurse_login_id'];
$staff_role = $_SESSION['nurse_role'];
$staff_unique_code = $_SESSION['nurse_unique_code'];
if($staff_role == 'nurse'){
$api_key_value = $_SESSION['api_key_value_nurse'];
$staff_unique_code = $_SESSION['nurse_unique_code'];
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$staff_unique_code);

	//echo $check_security;exit();
if($check_security == 1){
	$select_medicine_name = $obj_bill->selectData("id,product_name","tbl_product","where status!=0");
	if(mysqli_num_rows($select_medicine_name)>0){
		$x = 0;
		while($select_medicine_name_row = mysqli_fetch_array($select_medicine_name)){
			$response_arr[$x]['product_name'] = $select_medicine_name_row['product_name'];
			$response_arr[$x]['product_id'] = $select_medicine_name_row['id'];
		}
	}
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = 'Success';
}else{
	$response_arr[0]['status'] = 0;
	$response_arr[0]['msg'] = 'Something Went Wrong! Try Again';
}
}else{
	$response_arr[0]['status'] = 0;
	$response_arr[0]['msg'] = 'Unauthorised login';	
}
}else{
	$response_arr[0]['status'] = 0;
	$response_arr[0]['msg'] = 'Unauthorised login';
}
echo json_encode($response_arr);

?>