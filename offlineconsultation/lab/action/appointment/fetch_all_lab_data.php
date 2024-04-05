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

	//echo $check_security;exit();
if($check_security == 1){
		$url_val = $_POST['url_val'];
		$branch = $_POST['branch_id'];
		require_once '../../../_class_branch/query_branch.php';
		$obj_branch = new query_branch();
		$real_branch_id = 0;
		$branch_id = 0;
		$check_appointment = $obj->selectData("real_branch_id,branch_id","tbl_appointment","where id=$url_val");
		if(mysqli_num_rows($check_appointment)>0){
			$check_appointment_row = mysqli_fetch_array($check_appointment);
			$real_branch_id = $check_appointment_row['real_branch_id'];
			$branch_id = $check_appointment_row['branch_id'];
		}
		$x = 0;
		if($branch_id == $real_branch_id){
		$select_all_lab_data = $obj->selectData("id,test_name","tbl_add_lab_data","where appointment_id=$url_val");
	if(mysqli_num_rows($select_all_lab_data)>0){
		while($select_all_lab_data_row = mysqli_fetch_array($select_all_lab_data)){
			$response_arr[$x]['test_name'] = $select_all_lab_data_row['test_name'];
			$response_arr[$x]['id'] = $select_all_lab_data_row['id'];
			$x++;
		}
	}
		}else{
			$appointment_id = 0;
			$select_appointment_id = $obj_branch->selectData("id","tbl_appointment","where cross_appointment_id=$url_val");
			if(mysqli_num_rows($select_appointment_id)>0){
				$select_appointment_id_row = mysqli_fetch_array($select_appointment_id);
				$appointment_id = $select_appointment_id_row['id'];
			}
			$select_all_lab_data = $obj_branch->selectData("id,test_name","tbl_add_lab_data","where appointment_id=$appointment_id");
	if(mysqli_num_rows($select_all_lab_data)>0){
		while($select_all_lab_data_row = mysqli_fetch_array($select_all_lab_data)){
			$response_arr[$x]['test_name'] = $select_all_lab_data_row['test_name'];
			$response_arr[$x]['id'] = $select_all_lab_data_row['id'];
			$x++;
		}
	}
		}
	}
	}
}
echo json_encode($response_arr);
	?>