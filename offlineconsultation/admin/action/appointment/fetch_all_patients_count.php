<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$days_re=date('Y-m-d');
$times=date('h:i:s A');
$c_year = date('Y');
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
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$search_val = $_POST['search_val'];
	$where_date_clause = '';
	$where_date_serach = '';
	$response_arr[0]['current_date'] = '';
	if($search_val != ''){
		$where_date_serach = " and (tbl_patient.name like '%$search_val%' or tbl_patient.phone like '%$search_val%' or tbl_patient.place like '%$search_val%' or tbl_patient.unique_id like '%$search_val%')";
	}
	
	
	$select_all_data = $obj->selectData("count(tbl_patient.id) as id","tbl_patient","where tbl_patient.status!=0 $where_date_clause $where_date_serach ORDER BY tbl_patient.id desc");
	if(mysqli_num_rows($select_all_data)>0){
		$response_arr[0]['data_status'] = 1;
		$x = 0;
		$select_all_data_row = mysqli_fetch_array($select_all_data);
		if($select_all_data_row['id'] != null){
			$response_arr[0]['count_id'] = $select_all_data_row['id'];
		}
		
	}else{
		$response_arr[0]['count_id'] = 0;
		$response_arr[0]['data_status'] = 0;
	}
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = 'Success';
}else{
	$response_arr[0]['count_id'] = 0;
	$response_arr[0]['status'] = 0;
	$response_arr[0]['msg'] = 'Something Went Wrong! Try Again';
}
}else{
	$response_arr[0]['count_id'] = 0;
	$response_arr[0]['status'] = 0;
	$response_arr[0]['msg'] = 'Unauthorised login';	
}
}else{
	$response_arr[$x]['count_id'] = 0;
	$response_arr[0]['status'] = 0;
	$response_arr[0]['msg'] = 'Unauthorised login';
}
echo json_encode($response_arr);
?>