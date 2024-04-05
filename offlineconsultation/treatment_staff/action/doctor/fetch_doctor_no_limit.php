<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$c_days=date('Y-m-d');
$times=date('h:i:s A');
$c_year = date('Y');
if(isset($_SESSION['doctor_login_id'])){
$login_id = $_SESSION['doctor_login_id'];
$staff_role = $_SESSION['doctor_role'];
$staff_unique_code = $_SESSION['doctor_unique_code'];
if($staff_role == 'doctor'){
$api_key_value = $_SESSION['api_key_value_doctor'];
$staff_unique_code = $_SESSION['doctor_unique_code'];
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$staff_unique_code);
	//echo $check_security;exit();
if($check_security == 1){
	$where_search = '';
	$search_val = $_POST['doctor_search'];
	if($search_val != ''){
		$where_search = " and doctor_name like '%$search_val%'";
	}
	$select_all_staff = $obj->selectData("id,doctor_name,department_id,login_id","tbl_doctor","where status!=0 and login_id=$login_id");
	
	if(mysqli_num_rows($select_all_staff)>0){
		$x = 0;
		$response_arr[0]['data_status'] = 1;
		while($select_all_staff_row = mysqli_fetch_array($select_all_staff)){
			$response_arr[$x]['id'] = $select_all_staff_row['id'];
			$response_arr[$x]['doctor_name'] = $select_all_staff_row['doctor_name'];
			$response_arr[$x]['login_id'] = $select_all_staff_row['login_id'];
			$department_id = $select_all_staff_row['department_id'];
			$select_dep_name = $obj->selectData("department_name","tbl_department","where id=$department_id");
			if(mysqli_num_rows($select_dep_name)){
				$select_dep_name_row = mysqli_fetch_array($select_dep_name);
				$department_name = $select_dep_name_row['department_name'];
			}
			$response_arr[$x]['doctor_name_dep'] = $select_all_staff_row['doctor_name'].'('.$department_name.')';
			$x++;
		}
	}else{
		$response_arr[0]['data_status'] = 0;
	}
	
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = 'Success';
	//tbl_branch
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