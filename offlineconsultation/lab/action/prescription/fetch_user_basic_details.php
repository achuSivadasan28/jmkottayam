<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
include_once '../SMS/sendsms.php';
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$c_days=date('Y-m-d');
$times=date('h:i:s A');
$c_year = date('Y');
if(isset($_SESSION['lab_login_id'])){
$login_id = $_SESSION['lab_login_id'];
$staff_role = $_SESSION['lab_role'];
$staff_unique_code = $_SESSION['lab_unique_code'];
if($staff_role == 'lab'){
$api_key_value = $_SESSION['api_key_value_lab'];
$staff_unique_code = $_SESSION['lab_unique_code'];
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$staff_unique_code);
$date_arr = [];
	//echo $check_security;exit();
if($check_security == 1){
	$x = 0;
	$current_patient_uniqueid = $_POST['patient_pk_id'];
	$select_all_prescription_data = $obj->selectData("id,name,age,gender,phone,address,place","tbl_patient","where unique_id='$current_patient_uniqueid'");
	if(mysqli_num_rows($select_all_prescription_data)>0){
		while($select_all_prescription_data_row = mysqli_fetch_array($select_all_prescription_data)){
			$response_arr[0]['name'] = $select_all_prescription_data_row['name'];
			$response_arr[0]['age'] = $select_all_prescription_data_row['age'];
			$response_arr[0]['gender'] = $select_all_prescription_data_row['gender'];
			$response_arr[0]['phone'] = $select_all_prescription_data_row['phone'];
			$response_arr[0]['address'] = $select_all_prescription_data_row['address'];
			$response_arr[0]['place'] = $select_all_prescription_data_row['place'];
			$response_arr[0]['patient_pk_id'] = $current_patient_uniqueid;
			$patient_id = $select_all_prescription_data_row['id'];
			$select_visit_count = $obj->selectData("count(id) as id","tbl_appointment","where patient_id=$patient_id and status!=0 and appointment_status=2");
			$select_visit_count_row = mysqli_fetch_array($select_visit_count);
			if($select_visit_count_row['id'] != null){
				$count = $select_visit_count_row['id'];
			}else{
				$count = 0;
			}
			$response_arr[0]['count'] = $count;
		}
	}
	//tbl_prescription_medicine_data
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = 'success';
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